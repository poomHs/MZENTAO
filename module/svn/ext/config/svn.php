<?php
$svnClient = substr(__FILE__, 0, strpos(__FILE__, 'zentao')) . 'sliksvn\svn.exe';
$config->svn = new stdClass();
$config->svn->encodings = 'utf-8';
$config->svn->client    = 'C:\wamp64\www\zentao\SlikSvn\bin\svn.exe';

$i = 1;
$config->svn->repos[$i]['path']     = 'svn://gitee.com/treeandmen/zendao';
$config->svn->repos[$i]['username'] = '270451369@qq.com';
$config->svn->repos[$i]['password'] = '!!my1030';
$config->svn->repos[$i]['reponame'] = '主线100';

$i ++;
$config->svn->repos[$i]['path']     = 'svn://gitee.com/treeandmen/zendao2';
$config->svn->repos[$i]['username'] = '270451369@qq.com';
$config->svn->repos[$i]['password'] = '!!my1030';
$config->svn->repos[$i]['reponame'] = '82分支';
