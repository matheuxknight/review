<?php

class QuestionController extends CommonController
{
	private $_bank;
	private $_question;
	
	public function loadbank($id=null)
	{
		if($this->_bank===null)
		{
			if($id === null)
				$id = getparam('id');
	
			$this->_bank = getdbo('Object', $id);
	
			if($this->_bank===null)
				throw new CHttpException(500, "The requested Object $id does not exist.");
		}
		
		return $this->_bank;
	}
	
	public function loadquestion($id=null)
	{
		if($this->_question===null)
		{
			if($id === null)
				$id = getparam('id');
	
			$this->_question = getdbo('QuizQuestion', $id);
	
			if($this->_question===null)
				throw new CHttpException(500, "The requested QuizQuestion $id does not exist.");
		}
	
		return $this->_question;
	}
	
	///////////////////////////////////////////////////////////////////////////
	
	public function actionCreateBank()
	{
		$object = new Object;
		$object->ext = new ObjectExt;
		$object->type = CMDB_OBJECTTYPE_QUESTIONBANK;
		$object->parentid = $_GET['id'];

		if(isset($_POST['Object']))
		{
			$filename = GetUploadedFilename();
			if($filename)
			{
				$data = file_get_contents($filename);
				@unlink($filename);

				if(empty($_POST['Object']['name']))
					$_POST['Object']['name'] = substr(basename($filename), 40);
			}
			
			$object2 = objectCreateData($object, $_GET['id'], $_POST['Object'], $_POST['ObjectExt']);
			if(!$object2)
			{
				$this->render('createbank', array('object'=>$object));
				return;
			}
	
			objectUpdateParent($object2, now());
			if($data) $this->importMoodle($object2, $data);
				
			$this->redirect(array('admin', 'id'=>$object2->id));
		}

		$this->render('createbank', array('object'=>$object));
	}
	
	public function actionAdmin()
	{
		$this->processAdminCommand();
		
		$object = $this->loadbank();
		$this->render('admin', array('object'=>$object));
	}

	public function actionAdmin_results()
	{
		$object = $this->loadbank();
		$this->renderPartial('admin_results', array('object'=>$object));
	}

	public function actionCloze_results()
	{
		$object = $this->loadbank();
		$this->renderPartial('cloze_results', array('object'=>$object));
	}

	public function actionCreate()
	{
		$object = $this->loadbank();
		$question = new QuizQuestion;
	
		$question->bankid = $object->id;
		$question->grade = 100;
		$question->penalty = 0;
		$question->shuffleanswers = true;
		$question->enumtype = CMDB_ENUMTYPE_LETTERLOW;
		
		if(isset($_POST['QuizQuestion']))
		{
			$question->attributes = $_POST['QuizQuestion'];
			if($question->save())
			{
				if(	$question->answertype == CMDB_QUIZQUESTION_TRUE || 
					$question->answertype == CMDB_QUIZQUESTION_FALSE)
				{
					$s = new QuizQuestionSelect;
					$s->valid = $question->answertype == CMDB_QUIZQUESTION_TRUE? 100: 0;
					$s->value = 'True';
					$s->questionid = $question->id;
					$s->save();
					
					$s = new QuizQuestionSelect;
					$s->valid = $question->answertype == CMDB_QUIZQUESTION_FALSE? 100: 0;
					$s->value = 'False';
					$s->questionid = $question->id;
					$s->save();
					
					$question->answertype = CMDB_QUIZQUESTION_SELECT;
					$question->save();
				}
				
				else if($question->answertype == CMDB_QUIZQUESTION_NONE || 
						$question->answertype == CMDB_QUIZQUESTION_CLOZE)
				{
					$question->penalty = 0;
					$question->grade = 0;
					$question->save();
				}
				
				$this->redirect(array('update', 'id'=>$question->id));
			}
		}
	
		$this->render('create', array('question'=>$question, 'object'=>$object));
	}
	
	public function actionUpdate()
	{
	//	debuglog($_POST);
		$question = $this->loadquestion();
		$object = $question->bank;
		
		if(isset($_POST['QuizQuestionShortText']) && !empty($_POST['QuizQuestionShortText']['value']))
		{
			$shorttext = getdbosql('QuizQuestionShortText', $_POST['QuizQuestionShortText']['id']);
			if(!$shorttext) $shorttext = new QuizQuestionShortText;
						
			$shorttext->attributes = $_POST['QuizQuestionShortText'];
			$shorttext->questionid = $_POST['QuizQuestion']['id'];
			$shorttext->save();
		}

		if(isset($_POST['QuizQuestionSelect']) && 
			(!empty($_POST['QuizQuestionSelect']['value']) || !empty($_POST['QuizQuestionSelect']['fileid'])))
		{
			$select = getdbo('QuizQuestionSelect', $_POST['QuizQuestionSelect']['id']);
			if(!$select) $select = new QuizQuestionSelect;
			
			$select->attributes = $_POST['QuizQuestionSelect'];
			$select->questionid = $_POST['QuizQuestion']['id'];
			$select->save();
		}
			
		if(isset($_POST['QuizQuestionMatching']) && 
			(!empty($_POST['QuizQuestionMatching']['value1']) || !empty($_POST['QuizQuestionMatching']['fileid1']) ||
			 !empty($_POST['QuizQuestionMatching']['value2']) || !empty($_POST['QuizQuestionMatching']['fileid2'])))
		{
			$select = getdbo('QuizQuestionMatching', $_POST['QuizQuestionMatching']['id']);
			if(!$select) $select = new QuizQuestionMatching;
			
			$select->attributes = $_POST['QuizQuestionMatching'];
			$select->questionid = $_POST['QuizQuestion']['id'];
			$select->save();
		}

		if(isset($_POST['QuizQuestion']))
		{
		//	debuglog($_POST['QuizQuestion']);
			$question->attributes=$_POST['QuizQuestion'];
			if($question->save())
			{
				if($question->answertype == CMDB_QUIZQUESTION_CLOZE)
				{
					// update all quizzes
					$list = getdbolist('Quiz', "quizid in (select quizid from QuizQuestionEnrollment where questionid=$question->id)");
					foreach($list as $quiz)
						QuizQuestionClozeUpdateEmbedded($quiz, $question);
				}
				
				user()->setFlash('message', 'Question saved.');
				$this->goback();
			//	$this->redirect(array('update', 'id'=>$question->id));
			}
		}
	
		$this->render('update', array('question'=>$question, 'object'=>$object));
	}
	
	public function actionPreview()
	{
		$question = $this->loadquestion();
		include "preview.php";
	//	$this->render('preview', array('question'=>$question));
	}
	
	public function actionCopyQuestions()
	{
		$bank = $this->loadbank();
		if(isset($_POST['all_questions']))
		{
			foreach($_POST['all_questions'] as $id=>$value)
			{
				$q1 = getdbo('QuizQuestion', $id);
				$q2 = new QuizQuestion;
				$q2->attributes = $q1->attributes;
				$q2->bankid = $bank->id;
				$q2->save();
				
				$list = getdbolist("QuizQuestionMatching", "questionid=$id");
				foreach($list as $m1)
				{
					$m2 = new QuizQuestionMatching;
					$m2->attributes = $m1->attributes;
					$m2->questionid = $q2->id;
					$m2->save();
				}
				
				$list = getdbolist("QuizQuestionSelect", "questionid=$id");
				foreach($list as $m1)
				{
					$m2 = new QuizQuestionSelect;
					$m2->attributes = $m1->attributes;
					$m2->questionid = $q2->id;
					$m2->save();
				}
				
				$list = getdbolist("QuizQuestionShortText", "questionid=$id");
				foreach($list as $m1)
				{
					$m2 = new QuizQuestionShortText;
					$m2->attributes = $m1->attributes;
					$m2->questionid = $q2->id;
					$m2->save();
				}
				
			}
	
			$this->redirect(array('admin', 'id'=>$bank->id));
		}
	
		$this->render('copyquestions', array('bank'=>$bank));
	}
	
	public function actionSaveSelect()
	{
		$item = getdbo('QuizQuestionSelect', getparam('id'));
		if($item)
		{
			$item->startpos = getparam('startpos');
			$item->duration = getparam('duration');
			$item->save();
		}
	
		$this->goback();
	}
	
	public function actionSaveMatching()
	{
		$item = getdbo('QuizQuestionMatching', getparam('id'));
		if($item)
		{
			if(getparam('index') == 1)
			{
				$item->startpos1 = getparam('startpos');
				$item->duration1 = getparam('duration');
			}
			
			else if(getparam('index') == 2)
			{
				$item->startpos2 = getparam('startpos');
				$item->duration2 = getparam('duration');
			}
			
			$item->save();
		}
	
		$this->goback();
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////
	
	public function actionDelete()
	{
		$question = $this->loadquestion();
		$object = $question->bank;
						
		$question->delete();
		$this->redirect(array('admin', 'id'=>$object->id));
	}
	
	public function actionDeleteShortText()
	{
		$item = getdbo('QuizQuestionShortText', getparam('id'));
		if($item) $item->delete();
		
		$this->goback();
	}
	
	public function actionDeleteSelect()
	{
		$item = getdbo('QuizQuestionSelect', getparam('id'));
		if($item) $item->delete();
		
		$this->goback();
	}
	
	public function actionDeleteMatching()
	{
		$item = getdbo('QuizQuestionMatching', getparam('id'));
		if($item) $item->delete();
		
		$this->goback();
	}
	
	protected function processAdminCommand()
	{
		if(isset($_POST['command'], $_POST['id']) && $_POST['command']==='delete')
		{
			$question = $this->loadquestion($_POST['id']);
			$object = $question->bank;
							
			$question->delete();
			$this->redirect(array('admin', 'id'=>$object->id));
		}
	}
	
	///////////////////////////////////////////////////////////////////////////////////////////
	
	public function actionResetFile()
	{
		$question = $this->loadquestion();
	
		$question->startpos = 0;
		$question->duration = 0;
	
		$question->fileid = 0;
		$question->save();
		
		$this->goback();
	}
	
	private function importMoodle($object, $data)
	{
		$data = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $data);
			
		$xml = simplexml_load_string($data);
		if(!$xml) return false;
		
		foreach($xml->question as $q)
		{
			if((string)$q->attributes()->type == 'category') continue;
			
			$name = (string)$q->name->text;
			
			$question = getdbosql('QuizQuestion', "bankid=$object->id and name='$name'");
			if($question) continue;
			
			$question = new QuizQuestion;
			$question->bankid = $object->id;
			$question->name = $name;
			$question->question = (string)$q->questiontext->text;
			$question->grade = (float)$q->defaultgrade*100;
			$question->penalty = (float)$q->penalty*100;
			$question->shuffleanswers = (string)$q->shuffleanswers=='true'? true: false;
			
			switch((string)$q->answernumbering)
			{
				case '123':
					$question->enumtype = CMDB_ENUMTYPE_NUMBER;
					break;

				case 'abc':
					$question->enumtype = CMDB_ENUMTYPE_LETTERLOW;
					break;
			
				case 'ABC':
					$question->enumtype = CMDB_ENUMTYPE_LETTERUP;
					break;
					
				default:
					$question->enumtype = CMDB_ENUMTYPE_NONE;
			}
			
			$question->save();
			
			switch((string)$q->attributes()->type)
			{
				case 'essay':
					$question->answertype = CMDB_QUIZQUESTION_LONGTEXT;
					break;
					
				case 'shortanswer':
					$question->answertype = CMDB_QUIZQUESTION_SHORTTEXT;
					foreach($q->answer as $a)
					{
						$short = new QuizQuestionShortText;
						$short->questionid = $question->id;
						$short->valid = (int)$a->attributes()->fraction;
						$short->value = strip_tags((string)$a->text);
						$short->save();
					}
					
					break;
					
				case 'truefalse':
				case 'multichoice':
					$question->answertype = CMDB_QUIZQUESTION_SELECT;
					foreach($q->answer as $a)
					{
						$select = new QuizQuestionSelect;
						$select->questionid = $question->id;
						$select->valid = (int)$a->attributes()->fraction;
						$select->value = strip_tags((string)$a->text);
						$select->save();
					}
					
					break;
					
				case 'matching':
					$question->answertype = CMDB_QUIZQUESTION_MATCHING;
					foreach($q->subquestion as $a)
					{
						$matching = new QuizQuestionMatching;
						$matching->questionid = $question->id;
						$matching->valid = 100;
						$matching->value1 = strip_tags((string)$a->text);
						$matching->value2 = strip_tags((string)$a->answer->text);
						$matching->save();
					}
					
					break;
					
				default:
					debuglog((string)$q->attributes()->type);
					$question->answertype = CMDB_QUIZQUESTION_NONE;
			}
			
			$question->save();
		}
		
		return true;
	}
	
}





