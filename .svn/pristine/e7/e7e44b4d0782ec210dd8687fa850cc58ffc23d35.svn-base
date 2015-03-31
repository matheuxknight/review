<?php

///////////////////////////////////////////////////////////////////////

function getdbo($class, $id)
{
//	debuglog($id);
	return CActiveRecord::model($class)->findByPk($id);
}

function getdbosql($class, $sql='1')
{
//	debuglog("$class, $sql");
	return CActiveRecord::model($class)->find($sql);
}

function getdbolist($class, $sql='1')
{
//	debuglog("sql $sql");
	return CActiveRecord::model($class)->findAll($sql);
}

function getdbocount($class, $sql='1')
{
//	debuglog("sql $sql");
	return CActiveRecord::model($class)->count($sql);
}

function dborun($sql)
{
	return app()->db->createCommand($sql)->execute();
}

function dboscalar($sql)
{
	$res = app()->db->createCommand($sql)->queryScalar();
//	debuglog("dboscalar: $res, $sql");
	return $res;
}

function dborow($sql)
{
	return app()->db->createCommand($sql)->queryRow();
}

function dbocolumn($sql)
{
//	debuglog("dbocolumn: $sql");
	return app()->db->createCommand($sql)->queryColumn();
}

function dbolist($sql)
{
//	debuglog("dbolist: $sql");
	return app()->db->createCommand($sql)->queryAll();;
}


