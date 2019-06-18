<?php
$svnClient = substr(__FILE__, 0, strpos(__FILE__, 'zentao')) . 'sliksvn\svn.exe';
$config->svn = new stdClass();
$config->svn->encodings = 'utf-8';
$config->svn->client    = 'F:\soft\xampp\zentao\SlikSvn\bin\svn.exe';
/**
 * $i = 1;
*$config->svn->repos[$i]['path']     = 'svn://gitee.com/treeandmen/zendao';
*$config->svn->repos[$i]['username'] = '270451369@qq.com';
*$config->svn->repos[$i]['password'] = 'poom';
*$config->svn->repos[$i]['reponame'] = '主线100';

*$i ++;
*$config->svn->repos[$i]['path']     = 'svn://gitee.com/treeandmen/zendao2';
*$config->svn->repos[$i]['username'] = '270451369@qq.com';
*$config->svn->repos[$i]['password'] = '!!my1030';
*$config->svn->repos[$i]['reponame'] = '82分支';
 */
$i = 1;
$config->svn->repos[$i]['path']     = 'http://172.20.183.104:30001/svn/bbc/trunk';
$config->svn->repos[$i]['username'] = 'poom_hs';
$config->svn->repos[$i]['password'] = '!!Qq1030';
$config->svn->repos[$i]['reponame'] = '主线100';

$i ++;
$config->svn->repos[$i]['path']     = 'http://172.20.183.104:30001/svn/bbc/branches/BBC_V1.0_BL';
$config->svn->repos[$i]['username'] = 'poom_hs';
$config->svn->repos[$i]['password'] = '!!Qq1030';
$config->svn->repos[$i]['reponame'] = '82分支';

$i ++;
$config->svn->repos[$i]['path']     = 'http://172.20.183.104:30001/svn/bbc/branches/BBC_V1.0_BL(temp%20branch)';
$config->svn->repos[$i]['username'] = 'poom_hs';
$config->svn->repos[$i]['password'] = '!!Qq1030';
$config->svn->repos[$i]['reponame'] = '临时分支';
