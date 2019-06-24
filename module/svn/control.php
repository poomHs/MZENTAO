<?php
/**
 * The control file of svn currentModule of ZenTaoPMS.
 *
 * @copyright   Copyright 2009-2015 青岛易软天创网络科技有限公司(QingDao Nature Easy Soft Network Technology Co,LTD, www.cnezsoft.com)
 * @license     ZPL (http://zpl.pub/page/zplv12.html)
 * @author      Chunsheng Wang <chunsheng@cnezsoft.com>
 * @package     svn
 * @version     $Id$
 * @link        http://www.zentao.net
 */
class svn extends control
{
    /**
     * Sync svn. 
     * 
     * @access public
     * @return void
     */
    public function run()
    {
        $this->svn->run();
    }

    /**
     * Diff a file.
     * 
     * @param  string $url 
     * @param  int    $revision 
     * @access public
     * @return void
     */
    public function diff($url, $revision)
    {
        $url = helper::safe64Decode($url);
        $this->view->url      = $url;
        $this->view->revision = $revision;
        $this->view->diff     = $this->svn->diff($url, $revision);
        
        $this->display();
    }

    /**
     * Cat a file.
     * 
     * @param  string $url 
     * @param  int    $revision 
     * @access public
     * @return void
     */
    public function cat($url, $revision)
    {
        $url = helper::safe64Decode($url);
        $this->view->url      = $url;
        $this->view->revision = $revision;
        $this->view->code     = $this->svn->cat($url, $revision);
        
       $this->display(); 
    }
   /**
     * ajax
     */
    public function ajaxSyncSvnInfo($method,$bugID)
    {
        var_dump('$method:'.$method.":".$bugID);
        $actions = $this->svn->getSyncAction($method, $bugID);
        $reposActions =  $this->filterSvncommitedAction($actions);
        die(json_encode($reposActions));
    }

    function filterSvncommitedAction($actions){
        $repos =   $this->svn->getRepos();
        $reposActions = array();
        global  $path ;
        foreach($repos  as $key=>$repo){
            $reposActions[$key]->reponame = $repo['reponame'];
            $reposActions[$key]->path = $repo['path'];
            $GLOBALS[$path] =  $repo['path'];
            $reposActions[$key]->actions  = array_filter($actions,function($action){
              
                 if($action->action !='svncommited' ){
                     return false;
                 }
                
                 $history = reset($action->history);//取第一个
                 if(empty($history)){
                    return false;
                 }
                  //判断是subversion的action 并且是同一个repo
                  if(($history->field=='subversion')&&($history->old== $GLOBALS[$path])){
                      return true;
                  }
             });
             $reposActions[$key]->actions = array_values($reposActions[$key]->actions);
             $reposActions[$key]->files = array_map(function($actionHis){ 
                return reset($actionHis->history)->new;
             },$reposActions[$key]->actions);
        }
        $diffFile = array();
        foreach($reposActions as $changeAction){
            $changesFile=array();
            foreach($changeAction->files as $files){
                $changesFile = array_merge($changesFile,explode('|',$files));
            }
            $changeAction->files=array_unique($changesFile);
            $diffFile = array_intersect_assoc($diffFile, $changeAction->files);//返回相同的文件
        }
        foreach($reposActions as $changeAction){
            if(empty($changeAction->files)){
                $changeAction->status = 0;//未提交
                continue;
            }
        
            $changeAction->files = array_diff($changeAction->files,$diffFile);//去除相同的文件 留下不同的
            if(empty($changeAction->files)){
                $changeAction->status = 1;//已提交
            }else{
                $changeAction->status = 2;//部分提交
            }
        }
        return $reposActions;
    }
    /**
     * Sync from the syncer by api.
     * 
     * @access public
     * @return void
     */
    public function apiSync()
    {
        if($this->post->logs)
        {
            $repoRoot = $this->post->repoRoot;
            $logs = stripslashes($this->post->logs);
            $logs = simplexml_load_string($logs);
            foreach($logs->logentry as $entry)
            {
                $parsedLogs[] = $this->svn->convertLog($entry);
            }
            $parsedObjects = array('stories' => array(), 'tasks' => array(), 'bugs' => array());
            foreach($parsedLogs as $log)
            {
                $objects = $this->svn->parseComment($log->msg);
                if($objects)
                {
                    $this->svn->saveAction2PMS($objects, $log, $repoRoot);
                    if($objects['stories']) $parsedObjects['stories'] = array_merge($parsedObjects['stories'], $objects['stories']);
                    if($objects['tasks'])   $parsedObjects['tasks'  ] = array_merge($parsedObjects['tasks'],   $objects['tasks']);
                    if($objects['bugs'])    $parsedObjects['bugs']    = array_merge($parsedObjects['bugs'],    $objects['bugs']);
                }
            }
            $parsedObjects['stories'] = array_unique($parsedObjects['stories']);
            $parsedObjects['tasks']   = array_unique($parsedObjects['tasks']);
            $parsedObjects['bugs']    = array_unique($parsedObjects['bugs']);
            $this->view->parsedObjects = $parsedObjects;
            $this->display();
            exit;
        }
    }
}
