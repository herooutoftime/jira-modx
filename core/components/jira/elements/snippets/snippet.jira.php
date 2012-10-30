<?php
/**
 * jira
 * JIRA Ticketing brought to MODx - Work in progress
 * 
 * Snippet which enables to handle standard processes for Atlassian Issue-Management 'JIRA'
 * UI is built with Twitter-Bootstrap
 * Includes:
 *  - Creating
 *      - WYSISWG-Editor
 *  - Adding attachments
 *  - Solving, closing, removing with commenting via AJAX interface
 *  - Listing issues
 *  - Filtering issues by type, priority, reporter, state and text search
 *  - Show details including:
 *      - Attachments
 *      - Progress
 *      - Subtasks
 *      - Watchers
 *      
 * @author Andreas Bilz <andreas@subsolutions.at>
 * @todo use static resources for transportation
 * @todo deal with external user stuff
 * @todo add lexicon entries for common usage
 * @todo flexible for jira customfields
 * @todo add dashboard widget
 * @todo implement caching system
 */

define('JIRA_URL', $modx->getOption('jira.host'));
define('USERNAME', $modx->getOption('jira.user'));
define('PASSWORD', $modx->getOption('jira.password'));
define('DETAIL_ID', $modx->getOption('jira.detail'));
define('EDIT_ID', $modx->getOption('jira.edit'));
define('AJAX_ID', $modx->getOption('jira.ajax'));
define('MODAL_ID', $modx->getOption('jira.modal'));
define('PROJECT', $modx->getOption('jira.project'));
define('ISSUE_TYPES', $modx->getOption('jira.issuetypes'));
define('TEMP_FOLDER', $modx->getOption('base_path') . 'admin/file_storage/');

if (!class_exists('Jira')) {
    
    class Jira {
        
        public function __construct() {
            global $modx;
            $this->modx = $modx;
            $this->props = $modx->properties;
            $this->modx_user = explode(',', $this->modx->getOption('jira.modx_users'));
        }
        
        public function add_javascript() {
            $ajax_url = $this->modx->makeUrl(AJAX_ID);
            $modal_url = $this->modx->makeUrl(MODAL_ID);
            $js =<<<JS
<script type="text/javascript">
jQuery(document).ready(function($){
    
    $.jira = {
        state: {
            'close' : 'Schlie&szlig;en',
            'solve' : 'L&ouml;sen'
        },
        type: {
            'close' : 'Ticket schlie&szlig;en',
            'solve' : 'Ticket l&ouml;sen'
        }
    }

    $('a.modal-window').bind('click', function(event) {
        $.item = {
            reference: $(this)
        };
        
        $('#modal').modal({
            remote: '$modal_url',
            keyboard: true
        });
        $('.modal-header h3').html($.item.reference.attr('title'));
        $('.modal-footer button.action')
            .html($.jira.state[$.item.reference.attr('name')])
            .attr('rel', $.item.reference.attr('rel'));
        event.preventDefault();
    });
    $('.action').bind('click', function(event){
        $.item = {
            reference: $(this)
        };
        $('.action').button('loading');
        var current = $(this);
        var comment = $('.modal-body textarea').val();
        var action = current.attr('name');
        var removal = ["solve", "close", "remove"];
        
        if($.inArray(action, removal) != '-1')
            $.item.reference.closest('.ticket').addClass('alert alert-error');
        
        $.ajax({
            type: "POST",
            url : "$ajax_url",
            data : { action : action, id : current.attr('rel'), comment : comment},
            success : function(data) {
                $('.action').button('toggle')
                if($.inArray(action, removal) != '-1')
                    $.item.reference.closest('.ticket').hide();
                $('#modal').modal('toggle');
                console.log($.item.reference)
            }
        })
        
        event.preventDefault();
    })
    
})
</script>
JS;
            $this->modx->regClientStartupHTMLBlock($js);
            return;
        }
        
        public function list_issues() {
            $this->add_javascript();
            $issues_response = $this->get_issues();
            //var_dump($issues_response);
            $issues = $issues_response->issues;
            
            $chunk = $this->modx->getChunk('jira_item');
            $pattern = array('[[+ticket]]','[[+summary]]', '[[+description]]', '[[+tags]]',
                             '[[+type_icon]]', '[[+bdg_class]]', '[[+percent]]',
                             '[[+status_text]]', '[[+status_icon]]', '[[+status_class]]',
                             '[[+created]]', '[[+since]]', '[[+modx_user]]');
            $i = 1;
            $output = $this->modx->getChunk('jira_filter');
            foreach($issues as $issue) {
                //if($i == 1)
                //    var_dump($issue);
                
                $modx_user = 'JIRA';
                if(in_array($issue->fields->customfield_10300, $this->modx_user)) {
                    $is_buli = 1;
                    $modx_user = $issue->fields->customfield_10300;
                }
                
                switch ($issue->fields->issuetype->id) {
                    case '1':
                        $bdg_class = 'important';
                        $type_icon = 'icon-warning-sign';
                        break;
                    case '3':
                        $bdg_class = 'warning';
                        $type_icon = 'icon-plus';
                        break;
                    case '4':
                        $bdg_class = 'info';
                        $type_icon = 'icon-arrow-up';
                        break;
                    case '5':
                        $bdg_class = 'info';
                        $type_icon = 'icon-arrow-down';
                        break;
                }
                
                $percent = $issue->fields->progress->percent;
                switch ($issue->fields->status->id) {
                    case '1':
                        $status_class = 'warning';
                        $status_icon = 'icon-road';
                        break;
                    case '5':
                        $status_class = 'success';
                        $status_icon = 'icon-ok-circle';
                        $percent = 100;
                        break;
                    case '6':
                        $status_class = 'inverse';
                        $status_icon = 'icon-ok-sign';
                        break;
                }
                
                //Not displayed
                $today = new DateTime();
                $created = new DateTime(date('Y-m-d', strtotime($issue->fields->created)));
                $interval = $today->diff($created);
                
                $replace = array(
                             'ticket'       => $issue->id,
                             'summary'      => $issue->fields->summary,
                             'description'  => str_replace('{html}', '', $issue->fields->description),
                             'tags'         => implode(', ', $issue->fields->labels),
                             'type_icon'    => $type_icon,
                             'bdg_class'    => $bdg_class,
                             'percent'      => $percent,
                             'status_text'  => $issue->fields->status->name,
                             'status_icon'  => $status_icon,
                             'status_class' => $status_class,
                             'created'      => date('d.m.Y H:i', strtotime($issue->fields->created)),
                             'since'        => $interval->format('%a Tagen'),
                             'modx_user'    => $modx_user,
                             );
                $output .= str_replace($pattern, $replace, $chunk);
                $i++;
            }
            $modal = $this->modx->getChunk('jira_modal');
            return '<div class="row-fluid">' . $output . '</div>' . $modal;
        }
        
        public function post_to($resource, $data) {
            $jdata = json_encode($data);
            $ch = curl_init();
            curl_setopt_array($ch, array(
                    CURLOPT_POST => 1,
                    CURLOPT_URL => JIRA_URL . '/rest/api/latest/' . $resource,
                    CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
                    CURLOPT_POSTFIELDS => $jdata,
                    CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                    CURLOPT_RETURNTRANSFER => true
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            $result_decode = json_decode($result);
            $this->send_mail($this->get_issue($result_decode->id), 'new');
            return $result_decode;
        }
        
        public function create_issue($issue) {
            return $this->post_to('issue', $issue);
        }
        
        public function async_action() {
            $post = $this->modx->request->getParameters(array('id', 'action', 'comment'), 'POST');
            $ticket_id = $post['id'];
            $action = $post['action'];
            
            if($action == 'remove') {
                $this->remove_issue($post);
            }
            
            if($action == 'solve') {
                $post['status'] = 5;
                $this->change_status($post);
            }
            
            //Remember: An issue need to be solved before allowed to be closed
            if($action == 'close') {
                $post['status'] = 2;
                $this->change_status($post);
            }
            //$this->send_mail('');
            return $ticket_id;
        }
        
        public function remove_issue($post) {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_CUSTOMREQUEST => 'DELETE',
                CURLOPT_URL => JIRA_URL . '/rest/api/latest/issue/' . $post['id'],
                CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
                CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                CURLOPT_RETURNTRANSFER => true
            ));
            $result = curl_exec($ch);
            curl_close($ch);
        }
        
        public function change_status($post) {
            $data = array(
                          'update'      =>
                            array(
                                'comment'   => array(
                                                     0 => array(
                                    'add'   => array(
                                        'body'  => $post['comment']
                                    ))
                                )
                            ),
                          'transition' => array('id' => $post['status']),
                          );
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POST => 1,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_URL => JIRA_URL . '/rest/api/latest/issue/' . $post['id'] . '/transitions',
                CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
                CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                CURLOPT_RETURNTRANSFER => true
            ));
            $result = curl_exec($ch);
            curl_close($ch);
        }
        
        public function update_issue($resource, $data, $action = null) {
            $req = $action == 1 ? 'DELETE' : 'PUT';
            $jdata = $action == 1 ? array() : json_encode($data);
            $ch = curl_init();
            curl_setopt_array($ch, array(
                    //CURLOPT_POST => 1,
                    CURLOPT_CUSTOMREQUEST => $req,
                    CURLOPT_URL => JIRA_URL . '/rest/api/latest/issue/' . $resource,
                    CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
                    CURLOPT_POSTFIELDS => $jdata,
                    CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                    CURLOPT_RETURNTRANSFER => true
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            $this->send_mail($this->get_issue($resource), 'update');
            return json_decode($result);
        }
        
        public function set_params($post) {
            //Set the text search parameters
            //Unset the original 'text' parameter
            //summary ~ jira OR description ~ jira OR comment ~ jira
            if(array_key_exists('text', $post)) {
                $post['summary'] = $post['text'];
                $post['description'] = $post['text'];
                $post['comment'] = $post['text'];
                $this->modx->setPlaceholder('text', $post['text']);
                unset($post['text']);
            }
            
            foreach($post as $key => $value) {
                //No value => Remove element from post storage
                if(empty($value)) {
                    unset($post[$key]);
                    continue;
                }
                //Standard Operator & Connector
                $operator = '=';
                $connector = ' AND ';
                //Check for a customfield search (e.g.: Externer Benutzer)
                if(is_numeric(substr($key, 2, strlen($key)))) {
                    $key = 'cf[' . substr($key, 2, strlen($key)) . ']';
                    $operator = '~';
                }
                //Check for a text search
                if(in_array($key, array('summary', 'description', 'comment'))) {
                    $operator = '~';
                    $connector = ' OR ';
                }
                $this->modx->setPlaceholder($key, $value);
                
                //Check if first element of array, then connector is 'AND'
                reset($post);
                if ($key === key($post))
                    $connector = ' AND ';
                //Concatenate the JQL string
                $jql_query .= $connector . $key . $operator . $value;
            }
            //Return it!
            return $jql_query;
        }
        
        public function get_issues() {
            //Enable specific POST-params
            $post = $this->modx->request->getParameters(array('issuetype','priority','cf10300', 'status','text'), 'POST');
            //
            if($post)
                $jql_query = $this->set_params($post);
            //Base JQL String: Project 'BULI' and exclude subtasks
            $jql = array(
                'jql'   => 'project = '. $this->modx->getOption('jira.project') .' AND issuetype IN ('. $this->modx->getOption('jira.issuetypes') .')' . $jql_query . ' ORDER BY status ASC, created DESC'
                );
            $json_jql = json_encode($jql);
            $this->modx->setPlaceholder('jql', $json_jql);
            
            $ch = curl_init();
            curl_setopt_array($ch, array(
                    CURLOPT_POST => false,
                    CURLOPT_URL => JIRA_URL . '/rest/api/latest/search',
                    CURLOPT_POSTFIELDS => $json_jql,
                    CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
                    CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                    CURLOPT_RETURNTRANSFER => true
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            //var_dump($result);
            return json_decode($result);
        }
        
        public function get_issue($ticket) {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_POST => false,
                CURLOPT_URL => JIRA_URL . '/rest/api/latest/issue/' . $ticket . '?expand=renderedFields,names,schema,transitions,operations,editmeta,changelog,html,watchers',
                CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
                CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                CURLOPT_RETURNTRANSFER => true
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            return json_decode($result);
        }
        
        public function get_watchers($ticket) {
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_POST => false,
                CURLOPT_URL => JIRA_URL . '/rest/api/latest/issue/' . $ticket . '/watchers',
                CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
                CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                CURLOPT_RETURNTRANSFER => true
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            $watchers = json_decode($result, true);
            
            foreach($watchers['watchers'] as $watcher) {
                $data = array(
                    'img'   => $watcher['avatarUrls']['48x48'],
                    'name'  => $watcher['displayName']
                              );
                $out .= $this->modx->getChunk('jira_watchers', $data);
            }
            return $out;
            
        }
        
        public function add_comment($post) {
            $data = array(
                'body'  => $post['comment']
                          );
            
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_POST => 1,
                CURLOPT_URL => JIRA_URL . '/rest/api/latest/issue/' . $post['ticket'] . '/comment',
                CURLOPT_USERPWD => USERNAME . ':' . PASSWORD,
                CURLOPT_POSTFIELDS => json_encode($data),
                CURLOPT_HTTPHEADER => array('Content-type: application/json'),
                CURLOPT_RETURNTRANSFER => true
            ));
            $result = curl_exec($ch);
            curl_close($ch);
            $this->send_mail($this->get_issue($post['ticket']), 'comment-new');
        }
        
        public function get_subtasks($subtasks) {
            foreach($subtasks as $subtask) {
                $subticket_array = array(
                    'summary'       => $subtask->fields->summary,
                    'ticket'        => $subtask->id,
                                         );
                $output .= $this->modx->getChunk('jira_subitem', $subticket_array);
            }
            return $output;
        }
        
        public function get_attachments($attachments) {
            foreach($attachments as $file) {
                $file_array = array(
                    'uri'   => $file->content,
                    'name'  => $file->filename,
                                    );
                $output .= $this->modx->getChunk('jira_attachment', $file_array);
            }
            return $output;
        }
        
        public function view_detail() {
            $this->add_javascript();
            //Get me the comment-specific-POST-params
            $post = $this->modx->request->getParameters(array('comment', 'add', 'ticket'), 'POST');
            //Add comment when meets requirements
            if(!empty($post['add']) && !empty($post['comment']))
                $this->add_comment($post);
            $ticket_id = $_GET['ticket'];
            $ticket = $this->get_issue($ticket_id);
            
            if($ticket_id != $ticket->id && $ticket_id != $ticket->key)
                return $this->modx->getChunk('jira_error', array('title' => 'Sorry!', 'text' => 'Konnte dieses Ticket nicht finden'));
            
            //Get attachments if available
            if(count($ticket->fields->attachment) > 0)
                $attachments = $this->get_attachments($ticket->fields->attachment);
            
            //Get watchers if watched
            if($ticket->fields->watches->watchCount > 0)
                $watchers = $this->get_watchers($ticket_id);
            
            //Get subtasks if available
            if(count($ticket->fields->subtasks) > 0)
                $subtasks = $this->get_subtasks($ticket->fields->subtasks);
            //Generate comment output
            $comments = '';
            $chunk = $this->modx->getChunk('jira_comment');
            $pattern = array('[[+author_name]]', '[[+body]]', '[[+created]]');
            foreach($ticket->fields->comment->comments as $comment) {
                $replace = array(
                    'author_name'   =>  $comment->author->name,
                    'body'          =>  $comment->body,
                    'created'       =>  date('d.m.Y H:i', strtotime($comment->created)),
                                       );
                $comments .= str_replace($pattern, $replace, $chunk);
            }
            //var_dump($ticket);
            
            $modx_user = 'SUBS';
            if(in_array($ticket->fields->customfield_10300, $this->modx_user)) {
                $is_buli = 1;
                $modx_user = $ticket->fields->customfield_10300;
            }
            
            $ticket_array = array(
                'ticket'        => $ticket->id,
                'summary'       => $ticket->fields->summary,
                'created'       => date('d.m.Y H:i', strtotime($ticket->fields->created)),
                'modx_user'     => $modx_user,
                'description'   => str_replace('{html}', '', $ticket->renderedFields->description),
                'issuetype'     => $ticket->fields->issuetype->id,
                'priority'      => $ticket->fields->priority->id,
                'tags'          => implode(', ', $ticket->fields->labels),
                'commentform'   => $this->modx->getChunk('jira_commentform', array('ticket' => $ticket->key)),
                'comments'      => $comments,
                'subtasks'      => $subtasks,
                'watchers'      => $watchers,
                'percent'       => $ticket->fields->progress->percent,
                'attachments'   => $attachments,
                                  );
            $modal = $this->modx->getChunk('jira_modal');
            return $this->modx->getChunk('jira_detail', $ticket_array) . $modal;
        }
        
        public function send_mail($ticket, $mode = null) {
            
            $ticket_array = array(
                'mode'          => $mode,
                'summary'       => $ticket->fields->summary,
                'created'       => date('d.m.Y H:i', strtotime($ticket->fields->created)),
                'modx_user'     => $ticket->fields->customfield_10300,
                'modx_email'    => $ticket->fields->customfield_10400,
                'description'   => $ticket->renderedFields->description,
                'issuetype'     => $ticket->fields->issuetype->id,
                'priority'      => $ticket->fields->priority->id,
                'tags'          => implode(', ', $ticket->fields->labels),
                'percent'       => $ticket->fields->progress->percent,
                                  );
            
            $message = $this->modx->getChunk($this->modx->getOption('jira.mail_chunk'), $ticket_array); 
            $this->modx->getService('mail', 'mail.modPHPMailer');
            $this->modx->mail->set(modMail::MAIL_BODY, $message);
            $this->modx->mail->set(modMail::MAIL_FROM,$this->modx->getOption('jira.mail_from'));
            $this->modx->mail->set(modMail::MAIL_FROM_NAME,$this->modx->getOption('jira.mail_from_name'));
            $this->modx->mail->set(modMail::MAIL_SENDER,$this->modx->getOption('jira.mail_sender'));
            $this->modx->mail->set(modMail::MAIL_PRIORITY, $ticket->fields->priority->id);
            $this->modx->mail->set(modMail::MAIL_SUBJECT,'JIRA-Ticket von ' . $ticket_array['modx_user']);
            $this->modx->mail->address('to',$this->modx->getOption('jira.mail_to'));
            $this->modx->mail->address('reply-to',$this->modx->getOption('jira.mail_reply_to'));
            $this->modx->mail->setHTML($this->modx->getOption('jira.mail_html'));
            if (!$this->modx->mail->send())
                $this->modx->log(modX::LOG_LEVEL_ERROR,'An error occurred while trying to send the email: '.$this->modx->mail->mailer->ErrorInfo);
            $this->modx->mail->reset();
        }
        
        public function add_editor() {
            $this->modx->regClientStartupHTMLBlock('<script src="'.$this->modx->getOption('assets_url') . 'components/tinymce/jscripts/tiny_mce/tiny_mce.js" type="text/javascript"></script>');
            $this->modx->regClientStartupHTMLBlock('
            <script type="text/javascript">
            tinyMCE.init({
                mode : "textareas"
            });
            </script>');
        }
        
        public function add_attachments($ticket, $files) {
            //curl -D- -u admin:admin -X POST -H "X-Atlassian-Token: nocheck" -F "file=@myfile.txt" http://myhost/rest/api/2/issue/TEST-123/attachments
            if(!$files || empty($files))
                return false;
            
            $data = array();
            foreach($files as $file) {
                $ready['file']['file'] = '@' . $file['name'];
                $ready['file']['name'] = $file['name'];
                $ready['file']['type'] = $file['type'];
                $ready['file']['tmp_name'] = $file['tmp_name'];
                $ready['file']['error'] = $file['error'];
                $ready['file']['size'] = $file['size'];
                
                //$data["file"] = "@/image.jpg;type=image/jpeg";
                
                if(move_uploaded_file($file['tmp_name'], TEMP_FOLDER . pathinfo($file['name'], PATHINFO_BASENAME)))
                    echo 'file uploaded to temporary storage';
                
                $url = JIRA_URL . '/rest/api/latest/issue/'.$ticket.'/attachments/';
                shell_exec('curl -D- -u andreas:ibelod -X POST -H "X-Atlassian-Token: nocheck" -F "file=@'.TEMP_FOLDER . pathinfo($file['name'], PATHINFO_BASENAME).'" ' . $url);
            }
        }
        
        public function save_issue() {
            //var_dump($_FILES);
            
            //Update an already existing issue
            if($_POST['del'] == 1)
                $result = $this->update_issue($_GET['ticket'], $issue, $_GET['del']);
            //No data at all...
            if(!$_POST['save'] && !$_POST['update'] && !$_GET['ticket']) {
                
                $this->add_editor();
                
                return $this->modx->getChunk('jira_form');
            }
            //This is an edit...
            if(!$_POST['update'] && $_GET['ticket']) {
                
                $this->add_editor();
                
                $ticket = $this->get_issue($_GET['ticket']);
                $ticket_array = array(
                    'summary'       => $ticket->fields->summary,
                    'description'   => str_replace('{html}', '', $ticket->renderedFields->description),
                    'issuetype'     => $ticket->fields->issuetype->id,
                    'priority'      => $ticket->fields->priority->id,
                    'tags'          => implode(', ', $ticket->fields->labels),
                    'modx_user'     => $ticket->fields->customfield_10300,
                    'modx_email'    => $ticket->fields->customfield_10400,
                    'update'        => 1,
                    'button_name'   => 'update',
                    'button_text'   => 'Aktualisieren'
                                      );
                return $this->modx->getChunk('jira_form', $ticket_array);
            }
            
            //Split string to array
            $tags = preg_split("/[s,]+/", $_POST['tags']);
            $tags[] = $this->modx->user->get('username');
            $type = $_POST['type'];
            
            $profile = $this->modx->user->getOne('Profile');
            
            $issue = array(
                    'fields' => array(
                            'project'           => array('key' => PROJECT),
                            'summary'           => $_POST['title'],
                            'description'       => '{html}' . $_POST['description'] . '{html}',
                            'labels'            => $tags,
                            'priority'          => array('id' => $_POST['priority']),
                            'issuetype'         => array('id' => $_POST['type']),
                            'customfield_10300' => $this->modx->user->get('username'),
                            'customfield_10400' => $profile->get('email'),
                    )
            );
            
            //Create new issue from scratch
            if($_POST['save']) {
                
                $this->add_editor();
                
                $result = $this->create_issue($issue);
                
                //Add the attachments
                $this->add_attachments($result->key, $_FILES);
                
                $msg_title = "Ticket erfolgreich erstellt";
                $msg_text = "Neues Ticket erstellt: " . JIRA_URL ."/browse/{$result->key}<br/>";
                $msg_text .= 'Ticket hier anschauen: <a href="' . $this->modx->makeUrl(DETAIL_ID, '', array('ticket' => $result->key)) . '">KLICK MICH</a>';
                
                $ticket = $this->get_issue($result->id);
                $ticket_array = array(
                    'summary'       => $ticket->fields->summary,
                    'description'   => $ticket->renderedFields->description,
                    'issuetype'     => $ticket->fields->issuetype->id,
                    'priority'      => $ticket->fields->priority->id,
                    'tags'          => implode(', ', $ticket->fields->labels),
                    'modx_user'     => $ticket->fields->customfield_10300,
                    'modx_email'    => $ticket->fields->customfield_10400,
                    'update'        => 1,
                    'button_name'   => 'update',
                    'button_text'   => 'Aktualisieren'
                                      );
                
            }
            
            //Update an already existing issue
            if($_POST['update']) {
                
                $this->add_editor();
                
                $result = $this->update_issue($_GET['ticket'], $issue);
                
                //Add the attachments
                $this->add_attachments($_GET['ticket'], $_FILES);
                
                $ticket = $this->get_issue($_GET['ticket']);
                $ticket_array = array(
                    'summary'       => $ticket->fields->summary,
                    'description'   => str_replace('{html}', '', $ticket->renderedFields->description),
                    'issuetype'     => $ticket->fields->issuetype->id,
                    'priority'      => $ticket->fields->priority->id,
                    'tags'          => implode(', ', $ticket->fields->labels),
                    'modx_user'     => $ticket->fields->customfield_10300,
                    'modx_email'    => $ticket->fields->customfield_10400,
                    'update'        => 1,
                    'button_name'   => 'update',
                    'button_text'   => 'Aktualisieren'
                                      );
                //var_dump($ticket);
                
                $key = $ticket->key;
                
                $msg_title = "Ticket erfolgreich aktualisiert";
                $msg_text = "Ticket editiert: " . JIRA_URL ."/browse/{$key}";
                $msg_text .= 'Ticket hier anschauen: <a href="' . $this->modx->makeUrl(DETAIL_ID, '', array('ticket' => $key)) . '">KLICK MICH</a>';
            }
            
            if (property_exists($result, 'errors')) {
                $msg_title = 'Error(s) creating issue';
                $msg_text = json_decode($result);
            }
            
            return $this->modx->getChunk('jira_form', array_merge($ticket_array, array('message.title' => $msg_title, 'message.text' => $msg_text)));
        }
    }
}

$jira = new Jira();
return $jira->$fn();