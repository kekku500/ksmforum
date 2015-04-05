<?php
/*
* $topic := Array([id], [name])
* $posts elemendid := Array([post_id], [parent_post_id], [content], 
* [post_edit_time], [depth], [position[,[user_id], [user_name], [deleted])
*/
?>
<!--  
<?xml-stylesheet type="text/xsl" href="<?php /*echo base_url()."assets/xslt/posts.xsl";*/ ?>" ?>
 -->
<postsdata>
    <info>
        <rootPostId><?php echo $posts[0]['post_id'];?></rootPostId>
        <rootPostIndent><?php echo -3*$posts[0]['depth'];?></rootPostIndent>
        <pageNr><?php echo $cur_page;?></pageNr>
        <pageOffset><?php echo $page_offset;?></pageOffset>
        <topicId><?php echo $topic['id'];?></topicId>
    </info>
    <posts><?php
        $max_depth = $this->config->item('max_post_depth')+$posts[0]['depth'];
        $post_count_stack = array();
        $prev_post_id = $posts[0]['post_id'];
        $posts_count = count($posts);
        for($i = 1;$i<$posts_count;$i++){
            $post = $posts[$i];
            $stack_size = count($post_count_stack);
            if($post['depth'] > $stack_size){ //depth inc
                array_push($post_count_stack, array(1, $prev_post_id));
            }else{ //same depth or depth dec
                if($post['depth'] < $stack_size){ //depth dec
                    $post_count_stack = array_slice($post_count_stack, 0, $post['depth']);
                    $stack_size = count($post_count_stack);
                }
                $post_count_stack[$stack_size-1][0]++; //inc last element*/
            }?>
            <post>
                <id><?php echo $post['post_id'];?></id>
                <indent><?php echo -3*($post['depth']-$posts[0]['depth']-1+(isset($extradepth) ? $extradepth : 0));?></indent><?php
                $goDeeper = ($post['depth'] > $max_depth);
                $goNext = ($post['depth']-$posts[0]['depth'] > 0 && 
                    end($post_count_stack)[0] > ($this->config->item('max_post_count')/($post['depth']-$posts[0]['depth'])));
                if($goNext && !($goDeeper)){
                    $max_post_count = intval(($this->config->item('max_post_count')/($post['depth']-$posts[0]['depth'])))?>
                    <pagination>
                        <nextpage>
                            <href><?php echo site_url(array('main', 'topic', $topic['id'], 1, end($post_count_stack)[1]));?></href>
                        </nextpage>
                        <ajaxnext>
                            <onclickParam>
                                <?php echo "'".base_url()."','".$topic['id']."', '1', '".end($post_count_stack)[1]."', '".$max_post_count."', '0', '".$post['post_id']."', '".($post['depth']-1)."', '".$cur_url_encoded."'";?>
                            </onclickParam>
                        </ajaxnext>
                    </pagination><?php
                }else if($goDeeper){?>
                    <pagination>
                        <deeperpage>
                            <href><?php echo site_url(array('main', 'topic', $topic['id'], 1, $prev_post_id));?></href>
                        </deeperpage>
                        <ajaxdeeper>
                            <onclickParam>
                                <?php echo "'".base_url()."','".$topic['id']."', '1', '".$prev_post_id."', '0', '0', '".$post['post_id']."', '".($post['depth']-1)."', '".$cur_url_encoded."'";?>
                            </onclickParam>
                        </ajaxdeeper>
                    </pagination><?php 
                }else{?>
                    <data>   
                        <parentId><?php echo $post['parent_post_id'];?></parentId>
                        <author><?php echo $post['user_name'];?></author>
                        <edittime><?php echo $post['post_edit_time'];?></edittime>
                        <content><?php                
                            if($post['deleted']){
                                echo $this->lang->line('post_deleted_content');
                            }else{
                                echo $this->security->xss_clean($post['content']); 
                            }?>
                        </content><?php
                        if ($this->auth->isLoggedIn() && !$post['deleted']){?>
                            <addpost>
                                <href><?php echo site_url(array('main', 'addpost', $post['post_id'], $cur_url_encoded));?></href>
                                <text><?php echo $this->lang->line('post_anchor_add');?></text>
                            </addpost><?php
                            if($this->auth->getUserId() == $post['user_id']){?>
                                <editpost>
                                    <href><?php echo site_url(array('main', 'editpost', $post['post_id'], $cur_url_encoded));?></href>
                                    <text><?php echo $this->lang->line('post_anchor_edit');?></text>
                                </editpost>
                                <delpost>
                                    <href><?php echo site_url(array('main', 'delpost', $post['post_id'], $cur_url_encoded));?></href>
                                    <text><?php echo $this->lang->line('post_anchor_del');?></text>
                                </delpost><?php
                            }
                        }?>
                    </data><?php
                }?>
            </post><?php
            $prev_post_id = $post['post_id'];
        }?>
    </posts><?php
    if($cur_page > 1 || $next_page_valid){?>
        <pagination><?php
            if($cur_page > 1){?>
                <prevpage>
                    <href><?php echo site_url(array('main', 'topic', $topic['id'], $cur_page-1, $posts[0]['post_id']));?></href>
                </prevpage><?php
            }
            if($next_page_valid){?>
                <nextpage>
                    <href><?php echo site_url(array('main', 'topic', $topic['id'], $cur_page+1, $posts[0]['post_id']));?></href>
                </nextpage>
                <ajaxnext>
                    <onclickParam>
                        <?php echo "'".base_url()."','".$topic['id']."', '".($cur_page+1)."', '".$posts[0]['post_id']."', '".$page_offset."', '0', '".$posts[0]['post_id']."', '".$posts[0]['depth']."', '".$cur_url_encoded."'";?>
                    </onclickParam>
                </ajaxnext><?php
            }?>
        </pagination><?php
    }?>
</postsdata>





