<?php

class QuizController extends CommonController
{
    public $defaultAction = 'show';

    private $_object;
    private $_quiz;
    private $_question;


    public function loadquiz()
    {
        $this->_quiz = getdbo('Quiz', getparam('id'));
        //	if(!$this->_quiz) throw new CHttpException(500, 'The requested quiz does not exist.');

        return $this->_quiz;
    }


    public function loadobject()
    {
        $this->_object = getdbo('Object', getparam('id'));
        if (!$this->_object) throw new CHttpException(500, 'The requested object does not exist.');

        return $this->_object;
    }


    public function loadquestion()
    {
        $this->_question = getdbo('QuizQuestion', getparam('id'));
        if (!$this->_question) throw new CHttpException(500, 'The requested question does not exist.');

        return $this->_question;
    }


    /////////////////////////////////////////////////////////////////////////////

    protected function processAdminCommand()
    {
        if (isset($_POST['command'], $_POST['id']) && $_POST['command'] === 'removeqqe') {
            $qqe = getdbo('QuizQuestionEnrollment', getparam('id'));
            if ($qqe) {
                if ($qqe->question->answertype == CMDB_QUIZQUESTION_CLOZE)
                    dborun("delete from QuizQuestionEnrollment where quizid=$qqe->quizid and clozeid=$qqe->questionid");

                $qqe->delete();
            }

            $this->refresh();
        }
    }


    private function createQuiz($object)
    {
        $this->_quiz = new Quiz;
        $this->_quiz->quizid = $object->id;

        $this->_quiz->gradingmethod = CMDB_QUIZGRADING_HIGH;

        $this->_quiz->allowback = true;
        $this->_quiz->allowvideo = true;
        $this->_quiz->passthreshold = 60;

        $this->_quiz->introfeedback = "<p>You are about to start this quiz. Press the start button below when you are ready.</p>";
        $this->_quiz->completefeedback = "<p>You have completed this quiz. Press the submit button below when you are ready to submit your answers to the server.</p>";

        //	$this->_quiz->passfeedback = "<p>Congratulations, you have successfully completed this quiz.</p>";
        //	$this->_quiz->failfeedback = "<p>Unfortunately, you have not successfully completed this quiz.</p>";

        $this->_quiz->passfeedback = "<p>Well done!</p>";
        $this->_quiz->failfeedback = "<p>Try again!</p>";

        $this->_quiz->save();
        return $this->_quiz;
    }


    ////////////////////////////////////////////////////////////////////////////////////////////

    public function actionShow()
    {
        if (user()->isGuest) return;

        $object = $this->loadobject();
        $quiz = $this->loadquiz();
        $user = getUser();

        createEnrollmentFromCourse($user, $object);

        if ($quiz->allowedattempt) {
            $count = getdbocount('QuizAttempt', "quizid=$quiz->quizid and userid=$user->id and status!=" . CMDB_QUIZATTEMPT_STARTED);
            if ($count >= $quiz->allowedattempt && $user->roleText == "student, ") {
                $this->render('show_denied', array('object' => $object, 'quiz' => $quiz, 'count' => $count));
                return;
            }
        }

        include "show.php";
    }


    public function actionUpdate()
    {
        $this->processAdminCommand();

        $object = $this->loadobject();
        $quiz = $this->loadquiz();

        if (!$quiz)
            $quiz = $this->createQuiz($object);

        if (isset($_POST['Quiz'])) {
            $quiz->attributes = $_POST['Quiz'];
            $quiz->timelimit = atosec($_POST['quiz_timelimit']);

            if ($quiz->save()) {
                user()->setFlash('message', 'Parameters saved.');
                $this->goback();
            }
        }

        $this->render('update', array('object' => $object, 'quiz' => $quiz));
    }


    public function actionAddQuestions()
    {
        $object = $this->loadobject();
        $quiz = $this->loadquiz();

        if (!$quiz)
            $quiz = $this->createQuiz($object);

        if (isset($_POST['all_questions'])) {
            $bankid = 0;
            foreach ($_POST['all_questions'] as $id => $value) {
                $qqe = new QuizQuestionEnrollment;
                $qqe->quizid = $quiz->quizid;
                $qqe->questionid = $id;
                $qqe->clozeid = 0;
                $qqe->displayorder = 0;
                $qqe->save();

                $question = getdbo('QuizQuestion', $id);

                if ($question->answertype == CMDB_QUIZQUESTION_CLOZE)
                    QuizQuestionClozeUpdateEmbedded($quiz, $question);

                if (!$bankid) {
                    $bankid = $quiz->bankid = $question->bankid;
                    $quiz->save();
                }
            }

            $this->redirect(array('update', 'id' => $quiz->quizid));
        }

        $this->render('addquestions', array('object' => $object, 'quiz' => $quiz));
    }


    //////////////////////////////////////////////////////////////////////////////////

    public function actionSetorder()
    {
        $qqe = getdbo('QuizQuestionEnrollment', getparam('id'));
        if (!$qqe) return;

        $order = getparam('order');
        $oldorder = $qqe->displayorder;

        $bros = getdbolist('QuizQuestionEnrollment', "quizid=$qqe->quizid order by displayorder");
        foreach ($bros as $n => $o) {
            if ($o->id == $qqe->id)
                $o->displayorder = $order;

            else if ($o->displayorder < $order && $o->displayorder < $oldorder)
                $o->displayorder = $n;

            else if ($o->displayorder > $order && $o->displayorder > $oldorder)
                $o->displayorder = $n;

            else if ($order < $oldorder)
                $o->displayorder = $n + 1;
            else
                $o->displayorder = $n - 1;

            $o->save();
        }
    }


    public function actionBank_results()
    {
        $object = getdbo('Object', getparam('id'));
        if (!$object) return;

        $this->renderPartial('bank_results', array('object' => $object));
    }


    /////////////////////////////////////////////////////////////////////////////////////

    public function actionXmlQuiz()
    {
        $object = $this->loadobject();
        $quiz = $this->loadquiz();
        $user = getUser();
        $course = getContextCourse();

        $questioncount = getdbocount('QuizQuestionEnrollment', "quizid=$quiz->quizid and clozeid=0");
        $attemptcount = getdbocount('QuizAttempt', "quizid=$quiz->quizid and userid=$user->id");
        $attempt = getdbosql('QuizAttempt', "quizid=$quiz->quizid and userid=$user->id and status=" . CMDB_QUIZATTEMPT_STARTED);
        $attemptid = $attempt ? $attempt->id : 0;
        $currentquestion = $attempt ? $attempt->currentquestion : -1;

        $starttime = $attempt ? strtotime($attempt->started) : 0;

        $quizimage = objectImageUrl($object);
        $userimage = userImageUrl($user);

        if ($quiz->shufflequestion)
            $list = getdbolist('QuizQuestionEnrollment', "quizid=$quiz->quizid and clozeid=0 order by rand()");
        else
            $list = getdbolist('QuizQuestionEnrollment', "quizid=$quiz->quizid and clozeid=0 order by displayorder");

        $usedevices = 0;
        $list2 = getdbolist('QuizQuestionEnrollment', "quizid=$quiz->quizid order by displayorder");
        foreach ($list2 as $l)
            if ($l->question->answertype == CMDB_QUIZQUESTION_RECORD ||
                $l->question->answertype == CMDB_QUIZQUESTION_COMPARATIVE
            )
                $usedevices = 1;

        header("Content-Type: text/xml");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        echo "<?xml version='1.0' encoding='utf-8' ?>";
        echo "<data>";
        echo "<quizinfo>";

        echo "<userid>$user->id</userid>";
        echo "<username>$user->name</username>";
        echo "<userimage>$userimage</userimage>";

        echo "<quizid>$quiz->quizid</quizid>";
        echo "<quizname>$object->name</quizname>";
        echo "<quizimage>$quizimage</quizimage>";

        if ($course) {
            echo "<courseid>$course->id</courseid>";
            echo "<coursename>$course->name</coursename>";
        }

        echo "<allowback>$quiz->allowback</allowback>";
        echo "<allowvideo>$quiz->allowvideo</allowvideo>";

        echo "<allowedattempt>$quiz->allowedattempt</allowedattempt>";
        echo "<timelimit>$quiz->timelimit</timelimit>";
        echo "<expiredaction>$quiz->expiredaction</expiredaction>";
        echo "<passthreshold>$quiz->passthreshold</passthreshold>";
        echo "<gradingmethod>$quiz->gradingmethod</gradingmethod>";
        echo "<applypenalties>$quiz->applypenalties</applypenalties>";
        echo "<passfeedback><![CDATA[$quiz->passfeedback]]></passfeedback>";
        echo "<failfeedback><![CDATA[$quiz->failfeedback]]></failfeedback>";
        echo "<questionperpage>$quiz->questionperpage</questionperpage>";
        echo "<shufflequestion>$quiz->shufflequestion</shufflequestion>";

        echo "<usedevices>$usedevices</usedevices>";
        echo "<questioncount>$questioncount</questioncount>";
        echo "<attemptcount>$attemptcount</attemptcount>";
        echo "<attemptid>$attemptid</attemptid>";
        echo "<currentquestion>$currentquestion</currentquestion>";
        echo "<starttime>$starttime</starttime>";

        echo "</quizinfo>";

        echo "<quizquestions>";

        foreach ($list as $l)
            echo "<value>$l->questionid</value>";

        echo "</quizquestions>";
        echo "</data>";
    }


    public function actionXmlAttempt()
    {
        $attempt = getdbo('QuizAttempt', getparam('id'));

        header("Content-Type: text/xml");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        $result = new \SimpleXMLElement('<result></result>');
        $result->addChild('id', $attempt->id);
        $result->addChild('quizId', $attempt->quizid);
        $result->addChild('userId', $attempt->userid);
        $result->addChild('courseId', $attempt->courseid);
        $php53now = DateTime::createFromFormat('Y-m-d G:i:s', $attempt->started);
        $result->addChild('started', $php53now->getTimestamp());
        $result->addChild('duration', $attempt->duration);
        $result->addChild('status', $attempt->status);
        $result->addChild('currentQuestion', $attempt->currentquestion);
        $result->addChild('result', $attempt->result);
        echo $result->asXML();
    }


    public function actionXmlPreview()
    {
        $question = $this->loadquestion();
        $object = $question->bank;
        $user = getUser();

        $quizimage = objectImageUrl($object);
        $userimage = userImageUrl($user);

        header("Content-Type: text/xml");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        echo "<?xml version='1.0' encoding='utf-8' ?>";
        echo "<data>";
        echo "<quizinfo>";

        echo "<userid>$user->id</userid>";
        echo "<username>$user->name</username>";
        echo "<userimage>$userimage</userimage>";

        echo "<quizid>0</quizid>";
        echo "<quizname>$object->name</quizname>";
        echo "<quizimage>$quizimage</quizimage>";

        echo "<allowback>1</allowback>";
        echo "<allowvideo>1</allowvideo>";

        echo "<allowedattempt>1</allowedattempt>";
        echo "<timelimit>0</timelimit>";
        echo "<expiredaction>0</expiredaction>";
        echo "<passthreshold>0</passthreshold>";
        echo "<gradingmethod>0</gradingmethod>";
        echo "<applypenalties>0</applypenalties>";
        echo "<passfeedback>0</passfeedback>";
        echo "<failfeedback>0</failfeedback>";
        echo "<questionperpage>0</questionperpage>";
        echo "<shufflequestion>0</shufflequestion>";

        echo "<usedevices>0</usedevices>";
        echo "<questioncount>1</questioncount>";
        echo "<attemptcount>0</attemptcount>";
        echo "<attemptid>0</attemptid>";
        echo "<currentquestion>0</currentquestion>";
        echo "<starttime>0</starttime>";

        echo "</quizinfo>";

        echo "<quizquestions>";
        echo "<value>$question->id</value>";
        echo "</quizquestions>";

        echo "</data>";
    }


    //////////////////////////////////////////////////////////////////////////////////

    public function actionDeleteAttempt()
    {
        $attempt = getdbo('QuizAttempt', getparam('id'));
        if ($attempt) {
            dborun("delete from QuizAttemptAnswer where attemptid=$attempt->id");
            $attempt->delete();
        }

        $this->goback();
    }


    public function actionHtmlIntro()
    {
        $object = $this->loadobject();
        $quiz = $this->loadquiz();
        $user = getUser();

        $attempts = getdbocount('QuizAttempt', "quizid=$quiz->quizid and userid=$user->id and status!=" . CMDB_QUIZATTEMPT_STARTED . "");
        $questioncount = getdbocount('QuizQuestionEnrollment', "quizid=$quiz->quizid and clozeid=0");
        $penaltiesapplied = $quiz->applypenalties ? 'Yes' : 'No';
        $timelimit = $quiz->timelimit ? sectoa($quiz->timelimit) : 'None';
        $allowedattempt = $quiz->allowedattempt ? $quiz->allowedattempt : 'None';

        // quiz start page
        echo "<h2>$object->name</h2>";
        echo "<p>Number of Questions: <b>$questioncount</b></p>";
        echo "<p>Pass Threshold: <b>$quiz->passthreshold</b></p>";
        echo "<p>Penalties Applied: <b>$penaltiesapplied</b></p>";
        echo "<p>Time Limit: <b>$timelimit</b></p>";
        if ($user->roleText == "student, ") {
            echo "<p>Attempt Limit: <b>$allowedattempt</b></p>";
        } else {
            echo "<p>Student Attempt Limit: <b>$allowedattempt</b></p>";
        }
        echo "<p>Your Attempts: <b>$attempts</b></p>";

        echo $quiz->introfeedback;
    }


    public function actionHtmlComplete()
    {
        $object = $this->loadobject();
        $quiz = $this->loadquiz();

        echo $quiz->completefeedback;
    }


    public function actionHtmlQuestion()
    {
        $question = $this->loadquestion();
        $object = $question->bank;

        echo processDoctext($object, $question->question);
    }


    ///////////////////////////////////////////////////////////////////////////////////////

    public function actionXmlQuestion()
    {
        $question = $this->loadquestion();

        header("Content-Type: text/xml");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        echo "<?xml version='1.0' encoding='utf-8' ?>";
        $this->sendQuestion($question);
    }


    private function sendQuestion($question)
    {
        $file = $question->file;
        echo "<question>";

        echo "<id>$question->id</id>";
        echo "<bankid>$question->bankid</bankid>";
        echo "<name>$question->name</name>";
        echo "<cloze><![CDATA[$question->cloze]]></cloze>";
        echo "<fileid>$question->fileid</fileid>";

        if ($question->file) {
            $imagename = fileUrl($file);

            echo "<filetype>$file->filetype</filetype>";
            echo "<hasvideo>$file->hasvideo</hasvideo>";
            echo "<imagename>$imagename</imagename>";
            echo "<startpos>$question->startpos</startpos>";
            echo "<duration>$question->duration</duration>";
        }

        echo "<answertype>$question->answertype</answertype>";
        echo "<enumtype>$question->enumtype</enumtype>";
        echo "<enumtype2>$question->enumtype2</enumtype2>";
        echo "<grade>$question->grade</grade>";
        echo "<penalty>$question->penalty</penalty>";
        echo "<timelimit>$question->timelimit</timelimit>";
        echo "<shuffleanswers>$question->shuffleanswers</shuffleanswers>";

        if ($question->answertype == CMDB_QUIZQUESTION_SELECT) {
            $this->sendQuestionSelect($question);
        } else if ($question->answertype == CMDB_QUIZQUESTION_CLOZE) {
            echo "<subquestions>";

            $b = preg_match_all('/{(\d+)}/', $question->cloze, $matches);
            if ($b) foreach ($matches[1] as $qid) {
                $q1 = getdbo('QuizQuestion', $qid);
                $this->sendQuestion($q1);
            }

            echo "</subquestions>";
        }

        echo "</question>";
    }


    ///////////////////////////////////////////////////////////////////////////////////////

    private function sendQuestionSelect($question)
    {
        if ($question->shuffleanswers)
            $list = getdbolist('QuizQuestionSelect', "questionid=$question->id order by rand()");
        else
            $list = getdbolist('QuizQuestionSelect', "questionid=$question->id order by id");

        echo "<questionselect>";

        foreach ($list as $i => $l) {
            $file = $l->file;
            $en = '';
            switch ($question->enumtype) {
                case CMDB_ENUMTYPE_NUMBER:
                    $en = $i + 1;
                    break;
                case CMDB_ENUMTYPE_LETTERLOW:
                    $en = chr(ord('a') + $i);
                    break;
                case CMDB_ENUMTYPE_LETTERUP:
                    $en = chr(ord('A') + $i);
                    break;
            }

            echo "<items>";
            echo "<id>$l->id</id>";
            echo "<valid>$l->valid</valid>";
            echo "<enum>$en</enum>";
            echo "<value><![CDATA[$l->value]]></value>";
            echo "<fileid>$l->fileid</fileid>";
            echo "<questionid>$l->questionid</questionid>";

            if ($file) {
                $imagename = fileUrl($file);

                echo "<filetype>$file->filetype</filetype>";
                echo "<hasvideo>$file->hasvideo</hasvideo>";
                echo "<imagename>$imagename</imagename>";
                echo "<startpos>$l->startpos</startpos>";
                echo "<duration>$l->duration</duration>";
            }

            echo "</items>";
        }

        echo "</questionselect>";
    }


    public function actionXmlQuestionMatching()
    {
        $question = $this->loadquestion();

        if ($question->shuffleanswers)
            $list = getdbolist('QuizQuestionMatching', "questionid=$question->id order by rand()");
        else
            $list = getdbolist('QuizQuestionMatching', "questionid=$question->id order by id");

        $slots2 = range(0, count($list) - 1);
        shuffle($slots2);

        header("Content-Type: text/xml");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        echo "<?xml version='1.0' encoding='utf-8' ?>";
        echo "<questionmatching>";

        foreach ($list as $i => $l) {
            $j = $slots2[$i];

            $en1 = '';
            switch ($question->enumtype) {
                case CMDB_ENUMTYPE_NUMBER:
                    $en1 = $i + 1;
                    break;
                case CMDB_ENUMTYPE_LETTERLOW:
                    $en1 = chr(ord('a') + $i);
                    break;
                case CMDB_ENUMTYPE_LETTERUP:
                    $en1 = chr(ord('A') + $i);
                    break;
            }

            $e2n = '';
            switch ($question->enumtype2) {
                case CMDB_ENUMTYPE_NUMBER:
                    $en2 = $j + 1;
                    break;
                case CMDB_ENUMTYPE_LETTERLOW:
                    $en2 = chr(ord('a') + $j);
                    break;
                case CMDB_ENUMTYPE_LETTERUP:
                    $en2 = chr(ord('A') + $j);
                    break;
            }

            echo "<items>";
            echo "<id>$l->id</id>";
            echo "<valid>$l->valid</valid>";
            echo "<questionid>$l->questionid</questionid>";

            echo "<item1>";
            echo "<id>$l->id</id>";
            echo "<slot>$i</slot>";
            echo "<enum>$en1</enum>";
            echo "<value><![CDATA[$l->value1]]></value>";
            echo "<fileid>$l->fileid1</fileid>";

            if ($l->file1) {
                $file = $l->file1;
                $imagename = fileUrl($file);

                echo "<filetype>$file->filetype</filetype>";
                echo "<hasvideo>$file->hasvideo</hasvideo>";
                echo "<imagename>$imagename</imagename>";
                echo "<startpos>$l->startpos1</startpos>";
                echo "<duration>$l->duration1</duration>";
            }

            echo "</item1>";

            echo "<item2>";
            echo "<id>$l->id</id>";
            echo "<slot>$j</slot>";
            echo "<enum>$en2</enum>";
            echo "<value><![CDATA[$l->value2]]></value>";
            echo "<fileid>$l->fileid2</fileid>";

            if ($l->file2) {
                $file = $l->file2;
                $imagename = fileUrl($file);

                echo "<filetype>$file->filetype</filetype>";
                echo "<hasvideo>$file->hasvideo</hasvideo>";
                echo "<imagename>$imagename</imagename>";
                echo "<startpos>$l->startpos2</startpos>";
                echo "<duration>$l->duration2</duration>";
            }

            echo "</item2>";

            echo "</items>";
        }

        echo "</questionmatching>";
    }


    /////////////////////////////////////////////////////////////////////////////////////////////////

    public function actionStartQuiz()
    {
        $object = $this->loadobject();
        $quiz = $this->loadquiz();
        $user = getUser();
        $course = getContextCourse();

        $attempt = new QuizAttempt;
        $attempt->quizid = $quiz->quizid;
        $attempt->userid = $user->id;
        $attempt->courseid = $course ? $course->id : 0;
        $attempt->started = now();
        $attempt->duration = 0;
        $attempt->currentquestion = -1;
        $attempt->status = CMDB_QUIZATTEMPT_STARTED;
        $attempt->save();

        header("Content-Type: text/xml");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        $result = new \SimpleXMLElement('<result></result>');
        $result->addChild('id', $attempt->id);
        $result->addChild('quizId', $attempt->quizid);
        $result->addChild('userId', $attempt->userid);
        $result->addChild('courseId', $attempt->courseid);
        $php53now = new DateTime('now');
        $result->addChild('started', $php53now->getTimestamp());
        $result->addChild('duration', $attempt->duration);
        $result->addChild('status', $attempt->status);
        $result->addChild('currentQuestion', $attempt->currentquestion);
        $result->addChild('result', $attempt->result);
        // Backward compatibility
        $result->addChild('attemptid', $attempt->id);
        echo $result->asXML();
        return;

        // old code
        echo "<?xml version='1.0' encoding='utf-8' ?>";
        echo "<result>";
        echo "<attemptid>$attempt->id</attemptid>";
        echo "</result>";
    }


    public function actionCompleteQuiz()
    {
        $attempt = getdbo('QuizAttempt', getparam('attemptid'));
        if (!$attempt) return;

        $quiz = getdbo('Quiz', $attempt->quizid);
        if (!$quiz) return;

        $attempt->status = CMDB_QUIZATTEMPT_COMPLETED;
        $attempt->duration = time() - strtotime($attempt->started);
        $attempt->save();

        QuizAutoCorrection($quiz, $attempt);
    }


    public function actionCancelQuiz()
    {
        $attempt = getdbo('QuizAttempt', getparam('attemptid'));
        if (!$attempt) return;

        $quiz = getdbo('Quiz', $attempt->quizid);
        if (!$quiz) return;

        $attempt->status = CMDB_QUIZATTEMPT_CANCELLED;
        $attempt->duration = time() - strtotime($attempt->started);
        $attempt->save();
    }


    ////////////////////////////////////////////////////////////////////////////////////////////

    public function actionXmlAnswer()
    {
        $attempt = getdbo('QuizAttempt', getparam('attemptid'));
        if (!$attempt) return;

        $question = getdbo('QuizQuestion', getparam('questionid'));
        if (!$question) return;

        $attempt->currentquestion = getparam('currentquestion');
        $attempt->duration = time() - strtotime($attempt->started);
        $attempt->save();

        header("Content-Type: text/xml");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        echo "<?xml version='1.0' encoding='utf-8' ?>";
        $this->sendAnswer($attempt, $question);
    }


    private function sendAnswer($attempt, $question)
    {
        $phpsessid = session_id();

        echo "<answer>";
        echo "<questionid>$question->id</questionid>";

        switch ($question->answertype) {
            case CMDB_QUIZQUESTION_SHORTTEXT:
                $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
                echo "<answershort>$answer->answershort</answershort>";

                break;

            case CMDB_QUIZQUESTION_LONGTEXT:
                $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
                echo "<answerlong><![CDATA[{$answer->answerlong}]]></answerlong>";

                break;

            case CMDB_QUIZQUESTION_SELECT:
                $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
                echo "<answerselectid>$answer->answerselectid</answerselectid>";

                break;

            case CMDB_QUIZQUESTION_MATCHING:
                $list = getdbolist('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
                foreach ($list as $item) {
                    echo "<answermatchings>";
                    echo "<answermatchingid1>$item->answermatchingid1</answermatchingid1>";
                    echo "<answermatchingid2>$item->answermatchingid2</answermatchingid2>";
                    echo "</answermatchings>";
                }

                break;

            case CMDB_QUIZQUESTION_RECORD:
                $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
                echo "<fileid>$answer->answerfileid</fileid>";

                if ($answer->answerfile) {
                    $tempname = SANSSPACE_TEMP . "/phpsessid=$phpsessid&questionid=$question->id.flv";
                    $filename = objectPathname($answer->answerfile);

                    @unlink($tempname);
                    @copy($filename, $tempname);
                }

                break;

            case CMDB_QUIZQUESTION_COMPARATIVE:
                $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
                echo "<fileid>$answer->answerfileid</fileid>";

                break;

            case CMDB_QUIZQUESTION_CLOZE:
                echo "<subanswers>";

                $b = preg_match_all('/{(\d+)}/', $question->cloze, $matches);
                if ($b) foreach ($matches[1] as $qid) {
                    $q1 = getdbo('QuizQuestion', $qid);
                    $this->sendAnswer($attempt, $q1);
                }

                echo "</subanswers>";
        }

        echo "</answer>";
    }


    /////////////////////////////////////////////////////////////////////////////////////////////

    public function actionSaveAnswer()
    {
        $user = getUser();
        $phpsessid = session_id();

        $attempt = getdbo('QuizAttempt', getparam('attemptid'));
        $question = getdbo('QuizQuestion', getparam('questionid'));
        //	$quiz = getdbo('Quiz', "quizid=$attempt->id");
        $object = getdbo('Object', $attempt->quizid);
        $courseid = getContextCourseId();

        switch ($question->answertype) {
            case CMDB_QUIZQUESTION_LONGTEXT:
                $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
                if (!$answer) {
                    $answer = new QuizAttemptAnswer;
                    $answer->attemptid = $attempt->id;
                    $answer->questionid = $question->id;
                }

                if ($_FILES['attachment'] && $parent = userRecordingFolder($object, $user, $courseid)) {
                    // todo remove older file if exists

                    $object = new Object;
                    $object->type = CMDB_OBJECTTYPE_FILE;
                    $object->name = $_FILES['attachment']['name'];

                    $object = objectInit($object, $parent->id);
                    if (!$object) return;

                    $object->pathname = $_FILES['attachment']['name'];
                    $object->save();

                    $rfile = new File;
                    $rfile->objectid = $object->id;
                    $rfile->originalid = $question->fileid;
                    // todo define filetype
//                    $rfile->filetype = CMDB_FILETYPE_MEDIA;
                    $rfile->mimetype = $_FILES['attachment']['type'];
                    $rfile->save();

                    $answer->answerfileid = $object->id;

                    $file = getdbo('VFile', $answer->answerfileid);
                    $filename = objectPathname($file);

                    $filename = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $filename);

                    @unlink($filename);

                    //	debuglog("rename($inname, $filename)");
                    move_uploaded_file($_FILES['attachment']['tmp_name'], $filename);

                    scanFile($file);
                }

                $answer->answerlong = getparam('answerlong');
                $answer->save();

                break;

            case CMDB_QUIZQUESTION_SHORTTEXT:
                $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
                if (!$answer) {
                    $answer = new QuizAttemptAnswer;
                    $answer->attemptid = $attempt->id;
                    $answer->questionid = $question->id;
                }

                $answer->answershort = getparam('answershort');
                $answer->save();

                break;

            case CMDB_QUIZQUESTION_SELECT:
                $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
                if (!$answer) {
                    $answer = new QuizAttemptAnswer;
                    $answer->attemptid = $attempt->id;
                    $answer->questionid = $question->id;
                }

                $answer->answerselectid = getparam('answerselectid') ?: null;
                $answer->save();

                break;

            case CMDB_QUIZQUESTION_MATCHING:
                // Remove previous reply
                dborun("DELETE FROM `quizattemptanswer` WHERE `attemptid`={$attempt->id} AND `questionid`={$question->id}");

                foreach ($_GET as $i1 => $i2) {
                    if (!is_numeric($i1)) continue;
                    //	debuglog("$i1 => $i2");

                    $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id and answermatchingid1=$i1");
                    if (!$answer) {
                        $answer = new QuizAttemptAnswer;
                        $answer->attemptid = $attempt->id;
                        $answer->questionid = $question->id;
                        $answer->answermatchingid1 = $i1;
                    }

                    $answer->answermatchingid2 = $i2;
                    $answer->save();
                }

                // New protocol support
                foreach (getparam('answermatchings') as $i1 => $i2) {
                    $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id and answermatchingid1=$i1");
                    if (!$answer) {
                        $answer = new QuizAttemptAnswer;
                        $answer->attemptid = $attempt->id;
                        $answer->questionid = $question->id;
                        $answer->answermatchingid1 = $i1;
                    }

                    $answer->answermatchingid2 = $i2;
                    $answer->save();
                }

                break;

            case CMDB_QUIZQUESTION_RECORD:
            case CMDB_QUIZQUESTION_COMPARATIVE:
                $answer = getdbosql('QuizAttemptAnswer', "attemptid=$attempt->id and questionid=$question->id");
                if (!$answer) {
                    $answer = new QuizAttemptAnswer;
                    $answer->attemptid = $attempt->id;
                    $answer->questionid = $question->id;
                    $answer->save();
                }

                if ($_FILES['record']) {
                    if (!$answer->answerfile) {
                        $parent = userRecordingFolder($object, $user, $courseid);
                        if (!$parent) return;

                        $object = new Object;
                        $object->type = CMDB_OBJECTTYPE_FILE;
                        $object->name = "attempt={$attempt->id},question={$question->id}" . '.wav';

                        $object = objectInit($object, $parent->id);
                        if (!$object) return;

                        $object->pathname = "{$object->id}.wav";
                        $object->save();

                        $rfile = new File;
                        $rfile->objectid = $object->id;
                        $rfile->originalid = $question->fileid;
                        $rfile->filetype = CMDB_FILETYPE_MEDIA;
                        $rfile->mimetype = 'audio/x-wav';
                        $rfile->hasaudio = 1;
                        $rfile->save();

                        $answer->answerfileid = $object->id;
                    }

                    $file = getdbo('VFile', $answer->answerfileid);
                    $filename = objectPathname($file);

                    $filename = str_replace(array('\\', '/'), DIRECTORY_SEPARATOR, $filename);

                    @unlink($filename);

                    //	debuglog("rename($inname, $filename)");
                    move_uploaded_file($_FILES['record']['tmp_name'], $filename);

                    scanFile($file);
                }

                $answer->save();
                break;
        }



        header("Content-Type: text/xml");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        $result = new \SimpleXMLElement('<result></result>');
        $result->addChild('id', $answer->id);
        echo $result->asXML();

    }


}










