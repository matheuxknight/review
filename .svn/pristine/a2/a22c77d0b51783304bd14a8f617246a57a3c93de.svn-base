<?php

class PermissionController extends CommonController
{
	public $defaultAction = 'admin';
	private $_permission;
	
	private function loadpermission()
	{
		$this->_permission = getdbo('Command', getparam('id'));
		return $this->_permission;
	}
	
	public function actionAdmin()
	{
		if(isset($_POST['allperms']))
		{
			dborun("delete from CommandEnrollment where objectid=0");
			foreach($_POST['setperm'] as $commandid=>$perms)
			{
				foreach($perms as $roleid=>$dummy)
				{
					$ce = new CommandEnrollment;
					$ce->roleid = $roleid;
					$ce->commandid = $commandid;
					$ce->objectid = 0;
					$ce->has = true;
					$ce->save();
				}
			}
			
			user()->setFlash('message', 'Permissions saved.');
			$this->goback();
		}
		
		$this->render('admin');
	}

	public function actionUpdate()
	{
		$permission = $this->loadpermission();
		if(isset($_POST['Command']))
		{
			$permission->attributes = $_POST['Command'];
			$permission->save();

			$this->redirect(array('admin'));
		}
		
		$this->render('update', array('permission'=>$permission));
	}
	
	public function actionResetPermissions()
	{
		dborun("update Object set custompermission=false");
		dborun("delete from Role");
		dborun("delete from Command");
		dborun("delete from CommandEnrollment");

		$roletable = RbacDefaultRoles();
		foreach($roletable as $roleitem)
		{
			$role = getdbo('Role', $roleitem['id']);
			$role = new Role;
			$role->id = $roleitem['id'];
			$role->name = $roleitem['name'];
			$role->description = $roleitem['description'];
			$role->type = $roleitem['type'];
			$role->save();
		}
		
		$commands = RbacDefaultCommands();
		foreach($commands as $c)
		{
			$command = new Command;
			$command->id = $c['id'];
			$command->name = $c['name'];
			$command->description = $c['description'];
			$command->title = $c['title'];
			$command->url = $c['url'];
			$command->objecttype = $c['objecttype'];
			$command->createitem = $c['createitem'];
			$command->hideadmin = $c['hideadmin'];
			$command->icon = $c['icon'];
			$command->save();
			
			foreach($c['roles'] as $roleid)
			{
				$ce = new CommandEnrollment;
				$ce->roleid = $roleid;
				$ce->commandid = $command->id;
				$ce->objectid = 0;
				$ce->has = true;
				$ce->save();
			}
		}

		user()->setFlash('message', 'Permissions reset.');
		controller()->goback();
	}

	////////////////////////////////////////////////////////////////
	
	public function actionSaveObject()
	{
		$id = getparam('id');
		$object = getdbo('Object', $id);
		
	//	dborun("delete from CommandEnrollment where objectid=$id");
		foreach($_POST['allperms'] as $commandid=>$perms)
		{
			foreach($perms as $roleid=>$d)
			{
				$has = $this->rbac->objectRoleAccess($commandid, $roleid, $object);
				$set = $_POST['setperm'][$commandid][$roleid]? true: false;
				
				if($set xor $has)
				{
					$ce = getdbosql('CommandEnrollment', "commandid=$commandid and roleid=$roleid and objectid=$id");
					if(!$ce)
					{
						$ce = new CommandEnrollment;
						$ce->commandid = $commandid;
						$ce->roleid = $roleid;
						$ce->objectid = $id;
						$ce->has = true;
					}
					
					$ce->has = $set;
					$ce->save();
				}
			}
		}
		
		$object->custompermission = true;
		$object->save();

		user()->setFlash('message', 'Permissions saved.');
		controller()->goback();
	}

	public function actionResetObject()
	{
		$id = getparam('id');
		dborun("delete from CommandEnrollment where objectid=$id");

		$object = getdbo('Object', $id);
		$object->custompermission = false;
		$object->save();

		user()->setFlash('message', 'Permissions reset.');
		controller()->goback();
	}
	
}


