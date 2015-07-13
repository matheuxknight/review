<?php

class SurveyController extends CommonController
{
    private $_object;
    private $_survey;


    public function loadobject($id = null)
    {
        if ($this->_object === null) {
            if ($id === null)
                $id = getparam('id');

            $this->_object = getdbo('Object', $id);

            if ($this->_object === null)
                throw new CHttpException(500, "The requested Object $id does not exist.");
        }

        return $this->_object;
    }


    public function loadsurvey($id = null)
    {
        if ($this->_survey === null) {
            if ($id === null)
                $id = getparam('id');

            $this->_survey = getdbo('Survey', $id);

            if ($this->_survey === null)
                throw new CHttpException(500, "The requested _survey $id does not exist.");
        }

        return $this->_survey;
    }


    ///////////////////////////////////////////////////////////////////////////

    public function actionAdmin()
    {
        //	$this->processAdminCommand();

        $object = $this->loadobject();
        $this->render('admin', array('object' => $object));
    }


    public function actionView()
    {
        $user = getUser();
        $object = $this->loadobject();

        createEnrollmentFromCourse($user, $object);

        include 'view.php';
        return;
        $this->render('view', array('object' => $object));
    }


    public function actionResults()
    {
        $object = $this->loadobject();
        $this->render('results', array('object' => $object));
    }


    ///////////////////////////////////////////////////////////////////////////

    public function actionCreate()
    {
        $object = $this->loadobject();
        $survey = new Survey;
        $survey->objectid = $object->id;
        $survey->enumtype = CMDB_ENUMTYPE_NUMBER;

        if (isset($_POST['Survey'])) {
            $survey->attributes = $_POST['Survey'];
            if ($survey->save()) {
                if ($survey->answertype == CMDB_SURVEYTYPE_YESNO) {
                    $s = new SurveyOption;
                    $s->value = 'Yes';
                    $s->surveyid = $survey->id;
                    $s->save();

                    $s = new SurveyOption;
                    $s->value = 'No';
                    $s->surveyid = $survey->id;
                    $s->save();

                    $survey->answertype = CMDB_SURVEYTYPE_SELECT;
                    $survey->save();
                } else if ($survey->answertype == CMDB_SURVEYTYPE_AGREEDIS) {
                    $s = new SurveyOption;
                    $s->value = 'Agree';
                    $s->surveyid = $survey->id;
                    $s->save();

                    $s = new SurveyOption;
                    $s->value = 'Disagree';
                    $s->surveyid = $survey->id;
                    $s->save();

                    $survey->answertype = CMDB_SURVEYTYPE_SELECT;
                    $survey->save();
                }

                $this->redirect(array('update', 'id' => $survey->id));
            }
        }

        $this->render('create', array('survey' => $survey, 'object' => $object));
    }


    public function actionUpdate()
    {
        $survey = $this->loadsurvey();

        if (isset($_POST['SurveyOption']) &&
            (!empty($_POST['SurveyOption']['value']) || !empty($_POST['SurveyOption']['fileid']))
        ) {
            $option = getdbo('SurveyOption', $_POST['SurveyOption']['id']);
            if (!$option) $option = new SurveyOption;

            $option->attributes = $_POST['SurveyOption'];
            $option->surveyid = $survey->id;
            $option->save();
        }

        if (isset($_POST['Survey'])) {
            $survey->attributes = $_POST['Survey'];
            if ($survey->save()) {
                user()->setFlash('message', 'Survey saved.');
                $this->goback();
            }
        }

        $this->render('update', array('survey' => $survey, 'object' => $survey->object));
    }


    ///////////////////////////////////////////////////////////////////////////////////////////

    public function actionDelete()
    {
        $survey = getdbo('Survey', getparam('id'));
        $survey->delete();

        $this->goback();
    }


    public function actionDeleteOption()
    {
        $option = getdbo('SurveyOption', getparam('id'));
        $option->delete();

        $this->goback();
    }


    public function actionResetFile()
    {
        $survey = $this->loadsurvey();

        $survey->startpos = 0;
        $survey->duration = 0;

        $survey->fileid = 0;
        $survey->save();

        $this->goback();
    }


    public function actionSaveOption()
    {
        $item = getdbo('SurveyOption', getparam('id'));
        if ($item) {
            $item->startpos = getparam('startpos');
            $item->duration = getparam('duration');
            $item->save();
        }

        $this->goback();
    }


    public function actionSetorder()
    {
        $survey = getdbo('Survey', getparam('id'));
        if (!$survey) return;

        $order = getparam('order');
        $oldorder = $survey->displayorder;

        $bros = getdbolist('Survey', "objectid=$survey->objectid order by displayorder");
        foreach ($bros as $n => $o) {
            if ($o->id == $survey->id)
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

        $this->goback();
    }


    ////////////////////////////////////////////////////////////////////////////////////////////

    public function actionHtmlQuestion()
    {
        $survey = $this->loadsurvey();
        echo $survey->question;

        if ($survey->answertype == CMDB_SURVEYTYPE_TEXT) {
            $user = getUser();
            $answer = getdbosql('SurveyAnswer', "surveyid=$survey->id and userid=$user->id");
        }
    }


    public function actionXmlSurvey()
    {
        $object = $this->loadobject();
        $surveys = getdbolist('Survey', "objectid=$object->id order by displayorder");

        header("Content-Type: text/xml");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        echo "<?xml version='1.0' encoding='utf-8' ?>";
        echo "<data>";

        echo Object2Xml($object);
        echo "<surveys>";

        foreach ($surveys as $survey) {
            echo "<survey>";

            echo "<id>$survey->id</id>";
            echo "<objectid>$survey->objectid</objectid>";
            echo "<displayorder>$survey->displayorder</displayorder>";
            echo "<answertype>$survey->answertype</answertype>";
            echo "<enumtype>$survey->enumtype</enumtype>";
            echo "<allowupdate>$survey->allowupdate</allowupdate>";
            echo "<allowmultiple>$survey->allowmultiple</allowmultiple>";
            echo "<fileid>$survey->fileid</fileid>";

            if ($survey->file) {
                $imagename = fileUrl($survey->file);

                echo "<filetype>{$survey->file->filetype}</filetype>";
                echo "<hasvideo>{$survey->file->hasvideo}</hasvideo>";
                echo "<imagename>$imagename</imagename>";
                echo "<startpos>$survey->startpos</startpos>";
                echo "<duration>$survey->duration</duration>";
            }

            if ($survey->answertype == CMDB_SURVEYTYPE_SELECT || $survey->answertype == CMDB_SURVEYTYPE_RANK)
                $this->sendSurveyOptions($survey);

            echo "</survey>";
        }

        echo "</surveys>";
        echo "</data>";
    }


    private function sendSurveyOptions($survey)
    {
        $options = getdbolist('SurveyOption', "surveyid=$survey->id order by id");
        echo "<options>";

        foreach ($options as $i => $f) {
            $en = '';
            switch ($survey->enumtype) {
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

            echo "<option>";
            echo "<id>$f->id</id>";
            echo "<surveyid>$f->surveyid</surveyid>";
            echo "<enum>$en</enum>";
            echo "<value><![CDATA[$f->value]]></value>";
            echo "<fileid>$f->fileid</fileid>";

            if ($f->file) {
                $imagename = fileUrl($f->file);

                echo "<filetype>{$f->file->filetype}</filetype>";
                echo "<hasvideo>{$f->file->hasvideo}</hasvideo>";
                echo "<imagename>$imagename</imagename>";
                echo "<startpos>$f->startpos</startpos>";
                echo "<duration>$f->duration</duration>";
            }

            echo "</option>";
        }

        echo "</options>";
    }


    public function actionXmlAnswer()
    {
        $user = getUser();

        $survey = $this->loadsurvey();
        if (!$survey) return;

        $courseid = getContextCourseId();
        //	if(!$course) return;

        header("Content-Type: text/xml");
        header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
        header('Pragma: no-cache');

        echo "<?xml version='1.0' encoding='utf-8' ?>";
        echo "<answer>";

        switch ($survey->answertype) {
            case CMDB_SURVEYTYPE_TEXT:
                $answer = getdbosql('SurveyAnswer', "surveyid=$survey->id and userid=$user->id and courseid=$courseid");
                echo "<answertext>$answer->answertext</answertext>";
                break;

            case CMDB_SURVEYTYPE_SELECT:
                $list = getdbolist('SurveyAnswer', "surveyid=$survey->id and userid=$user->id and courseid=$courseid");
                foreach ($list as $item)
                    echo "<answerselect>$item->optionid</answerselect>";

                break;

            case CMDB_SURVEYTYPE_RANK:
                $list = getdbolist('SurveyAnswer', "surveyid=$survey->id and userid=$user->id and courseid=$courseid");
                foreach ($list as $item) {
                    echo "<answerranks>";
                    echo "<answerselect>$item->optionid</answerselect>";
                    echo "<answerrank>$item->answerrank</answerrank>";
                    echo "</answerranks>";
                }

                break;
        }

        echo "</answer>";
    }


    //////////////////////////////////////////////////////////////////////////////////////////

    public function actionSaveAnswer()
    {
        $user = getUser();

        $survey = $this->loadsurvey();
        if (!$survey) return;

        $course = getContextCourse();
        if (!$course) return;

        switch ($survey->answertype) {
            case CMDB_SURVEYTYPE_TEXT:
                $answer = getdbosql('SurveyAnswer', "surveyid=$survey->id and userid=$user->id and courseid=$course->id");
                if (!$answer) {
                    $answer = new SurveyAnswer;
                    $answer->surveyid = $survey->id;
                    $answer->userid = $user->id;
                    $answer->courseid = $course->id;
                }

                $answer->answertext = getparam('answertext');
                $answer->save();

                break;

            case CMDB_SURVEYTYPE_SELECT:
                // delete olds
                $answers = getdbolist('SurveyAnswer', "surveyid=$survey->id and userid=$user->id and courseid=$course->id");
                foreach ($answers as $answer)
                    if (!isset($_GET[$answer->id]))
                        $answer->delete();

                // add news
                foreach ($_GET as $i => $id) {
                    if (!intval($i)) continue;

                    $answer = getdbosql('SurveyAnswer', "surveyid=$survey->id and optionid=$id and userid=$user->id and courseid=$course->id");
                    if (!$answer) {
                        $answer = new SurveyAnswer;
                        $answer->surveyid = $survey->id;
                        $answer->userid = $user->id;
                        $answer->courseid = $course->id;
                        $answer->optionid = $id;
                        $answer->save();
                    }
                }

                // New protocol support
                foreach (getparam('answerselect') as $id) {
                    $answer = new SurveyAnswer;
                    $answer->surveyid = $survey->id;
                    $answer->userid = $user->id;
                    $answer->courseid = $course->id;
                    $answer->optionid = $id;
                    $answer->save();
                }

                break;

            case CMDB_SURVEYTYPE_RANK:
                dborun("delete from SurveyAnswer where surveyid=$survey->id and userid=$user->id and courseid=$course->id");
                foreach ($_GET as $id => $rank) {
                    if (!intval($id)) continue;

                    $answer = new SurveyAnswer;
                    $answer->surveyid = $survey->id;
                    $answer->userid = $user->id;
                    $answer->courseid = $course->id;
                    $answer->optionid = $id;
                    $answer->answerrank = $rank;
                    $answer->save();
                }

                // New protocol support
                foreach (getparam('answerranks') as $id => $rank) {
                    $answer = new SurveyAnswer;
                    $answer->surveyid = $survey->id;
                    $answer->userid = $user->id;
                    $answer->courseid = $course->id;
                    $answer->optionid = $id;
                    $answer->answerrank = $rank;
                    $answer->save();
                }

                break;
        }
    }


}







