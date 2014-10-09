
						<ul>
							<li class="submenu">
								<a href="#"> <span>自媒体</span>
								</a>
								<ul>
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['edit-agency']) or isset($allowed_menu_items['edit-show']) or isset($allowed_menu_items['edit-contacts']) ) : ?>
									<li <?php echo ($active=="agency_infor") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>article/edit/?category=agency">-机构介绍</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['edit-teacher']) ) : ?>
									<li <?php echo ($active=="teacher") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>article/edit/?category=teachers">-师资力量</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-news']) ) : ?>
									<li <?php echo ($active=="news") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>article/list/?category=news">-机构动态</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-knowledge']) ) : ?>
									<li <?php echo ($active=="knowledge") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>article/list/?category=knowledge">-知识分享</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-classes']) or isset($allowed_menu_items['manage-course']) ) : ?>
									<li <?php echo ($active=="classes") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>classes/list/">-课程介绍</a>
									</li>
									<?php endif?>
								</ul>
							</li>
							<li class="submenu">
								<a href="#"> <span>学员管理</span>
								</a>
								<ul>
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['query-student']) or isset($allowed_menu_items['manage-student']) ) : ?>
									<li <?php echo ($active=="student") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>student/list/?status=1">-学生查询</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-works']) ) : ?>
									<li <?php echo ($active=="works") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>works/list/">-学生作品</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-ranking']) ) : ?>
									<li <?php echo ($active=="ranking") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>ranking/list/">-菁英榜</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-signup']) ) : ?>
									<li <?php echo ($active=="signup") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>course/infor/">-报名管理</a>
									</li>
									<?php endif?>									
								</ul>
							</li>
							<li class="submenu">
								<a href="#"> <span>信息发布</span>
								</a>
								<ul>
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-homework']) ) : ?>
									<li <?php echo ($active=="homework") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>homework/list/">-作业任务</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-daily_news']) ) : ?>
									<li <?php echo ($active=="daily-news") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>article/list/?category=daily-news">-每日讯息</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-score']) ) : ?>
									<li <?php echo ($active=="score") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>score/list/">-学生成绩</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-feedback']) ) : ?>
									<li <?php echo ($active=="teacher_feedback") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>feedback/topics/">-老师评语</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['reply-feedback']) ) : ?>
									<li <?php echo ($active=="student_feedback") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>feedback/topics/?from=student">-反馈管理</a>
									</li>
									<?php endif?>									
								</ul>
							</li>
							<li class="submenu">
								<a href="#"> <span>设置</span>
								</a>
								<ul>
									<?php if ( $allowed_menu_items == '*' or isset($allowed_menu_items['manage-setting']) ) : ?>
									<li <?php echo ($active=="setting") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>school/list/">-参数设置</a>
									</li>
									<?php endif?>
									
									<?php if ( $allowed_menu_items == '*' ) : ?>
									<li <?php echo ($active=="permission") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>permission/users/">-用户权限</a>
									</li>
									<?php endif?>
									
									<li <?php echo ($active=="change_password") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>login/pswd/">-密码修改</a>
									</li>									
								</ul>
							</li>
						</ul>
						