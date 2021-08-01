
            <div class="blog-posts single-post">
                <?php if ($post): ?>

                <?php 
                //print_r($post);
                ?>
                <article class="post post-large blog-single-post">
                    <div class="post-date">
                        <span class="day"><?php echo date('M d',strtotime($post['created_datetime'])); ?></span>
                        <!-- <span class="year"><?php //echo date('M',strtotime($post->date_posted));?></span> -->
                        <span class="month"><?php echo date('Y', strtotime($post['created_datetime'])); ?></span>
                    </div>

                    <div class="post-content">

                        <h2><a href="#"><?php echo $post['title'] ?></a></h2>
                        <div class="post-meta">
                            <span><i class="fas fa-user"></i> By <img src="<?=badge($post['badge']);?>">  <a href="<?php echo site_url('profile/view/'.$post['author'])?>"><?php echo $post['display_name']; ?></a> </span>
                            <span><i class="fas fa-tag"></i>
                                <?php foreach ($post['categories'] as $cat): ?>
                                    <?php echo $cat->name.' , '; ?>
                                <?php endforeach ?>
                            </span>
                            <span><i class="fas fa-comments"></i> <?php echo $post['comment_count']; ?> Comments</span>
                            <?php if ($post['modified_datetime']) : ?>
                                <span><i class="fas fa-calendar-alt"></i> Last Modified on <?php echo date('Y-m-d',strtotime($post['modified_datetime'])); ?> </span>
                            <?php endif; ?>
                        </div>

                        <div class="post-image">
                            <?php if ($post['feature_image']) : ?>
                                <div class="owl-carousel owl-theme" data-plugin-options="{'items':1}">
                                    <div>
                                        <div class="img-thumbnail d-block">
                                            <img class="img-fluid" src="<?php echo is_numeric($post['feature_image']) ? getFileUrl($post['feature_image']) : $post['feature_image']; ?>" alt="<?php echo $post['featured_image_alt'] ?>">
                                        </div>
                                    </div>

                                </div>

                            <?php endif ?>

                        </div>
                        <div class="description">
                            <?php echo $post['content'] ?>
                        </div>
                        

                        <div class="post-block post-share">
                            <h3 class="heading-primary"><i class="fas fa-share"></i>Share this post</h3>

                            <!-- AddThis Button BEGIN -->
                            <div class="addthis_toolbox addthis_default_style ">
                                <a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
                                <a class="addthis_button_tweet"></a>
                                <a class="addthis_button_pinterest_pinit"></a>
                                <a class="addthis_counter addthis_pill_style"></a>
                            </div>
                            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=xa-50faf75173aadc53"></script>
                            <!-- AddThis Button END -->

                        </div>

                        <div class="post-block post-author clearfix">
                            <h3 class="heading-primary"><i class="fas fa-user"></i>Author</h3>
                            <div class="img-thumbnail d-block">
                                <a href="<?php echo site_url('profile/view/'.$post['user_id']); ?>">
                                    <img src="<?php echo $post['avatar'] ?>" width="150" alt="">
                                </a>
                            </div>
                            <p> <img src="<?=badge($post['badge']);?>"> <strong class="name"><a href="#"><?php echo $post['display_name']; ?></a></strong></p>
                            <p><?php echo $post['bio']; ?> </p>
                        </div>

                        <div class="post-block post-comments clearfix">
                            <h3 class="heading-primary"><i class="fas fa-comments"></i>Comments (<?php echo count($comments); ?>)</h3>

                            <ul class="comments">
                                <?php if (count($comments) > 0): ?>

                                <?php foreach ($comments as $comment): ?>
                                        <?php // print_r($comment); ?>
                                <li>
                                    <div class="comment">
                                        <div class="img-thumbnail d-none d-sm-block">
                                            <img class="avatar" alt="" src="<?php echo $comment->avatar?$comment->avatar: 'http://www.gravatar.com/avatar/00000000000000000000000000000000?d=mm&s=70'; ?>">
                                        </div>
                                        <div class="comment-block">
                                            <div class="comment-arrow"></div>
                                            <span class="comment-by">
                                                <img src="<?=badge($comment->badge);?>"> <strong><?php echo $comment->author; ?></strong>
<!--                                                <span class="float-right">-->
<!--                                                    <span> <a href="#"><i class="fas fa-reply"></i> Reply</a></span>-->
<!--                                                </span>-->
                                            </span>
                                            <p><?php echo $comment->comment; ?></p>
                                            <span class="date float-right"><?php echo date("M d, Y", strtotime($comment->date)); ?> at <?php echo date('h:i A', strtotime($comment->date)); ?></span>
                                        </div>
                                    </div>


                                </li>
                                <?php endforeach; ?>
                                <?php else: ?>
                                    <p>No comment</p>
                                <?php endif; ?>


                            </ul>

                        </div>



                        <div class="post-block post-leave-comment">
                            <h3 class="heading-primary">Leave a comment</h3>

                            <?php
                            if($success=$this->session->flashdata('success')){
                                echo '<p>'.$success.'</p>';
                            }
                            if($error=$this->session->flashdata('error')){
                                echo '<p>'.$error.'</p>';
                            }
                            ?>

                            <form action="" method="post">
                                <?php if ( (setting('guest_comment')== 1) && (!$this->ion_auth->logged_in() )): ?>
                                <div class="form-row">

                                    <div class="form-group col-lg-6">
                                        <label>Your name *</label>
                                        <input name="nickname" id="nickname" maxlength="100 type="text" value="<?php echo set_value('nickname'); ?>" class="form-control" placeholder="<?php echo lang('nickname'); ?>" required />

                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label>Your email address *</label>
                                        <input name="email" maxlength="100" id="email" type="email" value="<?php echo set_value('email'); ?>" class="form-control" placeholder="" required />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>Comment *</label>
                                        <textarea name="comment"  maxlength="5000" id="comment" rows="10" class="form-control" placeholder="" required><?php echo set_value('comment'); ?></textarea>

                                    </div>
                                </div>
                                <?php if ($this->config->item('use_recaptcha') == 1) : ?>
                                    <div class="form-row">
                                        <script src='https://www.google.com/recaptcha/api.js'></script>
                                        <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha_site_key') ?>"></div>
                                    </div>
                                <?php endif ?>

                                <?php if ($this->config->item('use_honeypot') == 1) : ?>
                                    <div style="position: absolute; left: -999em;">
                                        <input name="date_stamp_gotcha" id="date_stamp_gotcha" type="text" value="" class="form-control">
                                    </div>
                                <?php endif ?>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <input type="submit" value="Post Comment" class="btn btn-primary btn-lg" data-loading-text="Loading...">
                                    </div>
                                </div>
                                <?php elseif($this->ion_auth->logged_in()): ?>
                                <div class="form-row">
                                    <div class="form-group col-lg-12">
                                        <label for="">Name *</label>
                                        <input name="nickname" id="nickname" type="text" value="<?php echo empty($user_details['alias']) ? $user_details['first_name'].' '.$user_details['last_name'] : $user_details['alias']; ?>" class="form-control" placeholder="" required disabled />
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <label>Comment *</label>
                                        <textarea name="comment"  maxlength="5000" id="comment" rows="10" class="form-control" placeholder="" required><?php echo set_value('comment'); ?></textarea>

                                    </div>
                                </div>
                                <?php if ($this->config->item('use_recaptcha') == 1) : ?>
                                    <div class="form-row">
                                        <script src='https://www.google.com/recaptcha/api.js'></script>
                                        <div class="g-recaptcha" data-sitekey="<?php echo $this->config->item('recaptcha_site_key') ?>"></div>
                                    </div>
                                <?php endif ?>

                                <?php if ($this->config->item('use_honeypot') == 1) : ?>
                                    <div style="position: absolute; left: -999em;">
                                        <input name="date_stamp_gotcha" id="date_stamp_gotcha" type="text" value="" class="form-control">
                                    </div>
                                <?php endif ?>
                                <div class="form-row">
                                    <div class="form-group col">
                                        <input type="submit" value="Post Comment" class="btn btn-primary btn-lg" data-loading-text="Loading...">
                                    </div>
                                </div>
                                <?php else: ?>
                                <a href="<?php echo site_url('login'); ?>?referrer=<?php echo $this->uri->uri_string(); ?>" class="btn btn-primary">Login To Post Comment</a>
                                <?php endif; ?>
                                
                                
                            </form>
                        </div>

                    </div>
                </article>
                <?php endif; ?>

            </div>
       
