
						<ul>
							<li class="submenu">
								<a href="#"> <span>自媒体</span>
								</a>
								<ul>
									<li <?php echo ($active=="agency") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>introduction">-机构介绍</a>
									</li>
									
									<li <?php echo ($active=="teachers") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>teachers">-师资力量</a>
									</li>
									
									<li <?php echo ($active=="news") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>news/list/">-机构动态</a>
									</li>
									
									<li <?php echo ($active=="knowledge") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>article/list/">-知识分享</a>
									</li>
									
									<li <?php echo ($active=="class") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>class/list/">-课程介绍</a>
									</li>
								</ul>
							</li>
							<li class="submenu">
								<a href="#"> <span>学员管理</span>
								</a>
								<ul>
									<li <?php echo ($active=="student") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>student/list/">-学生查询</a>
									</li>
									
									<li <?php echo ($active=="works") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>works/list/">-学生作品</a>
									</li>
									
									<li <?php echo ($active=="top") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>top/list/">-菁英榜</a>
									</li>
									
									<li <?php echo ($active=="signup") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>signup/list/">-报名管理</a>
									</li>								
								</ul>
							</li>
							<li class="submenu">
								<a href="#"> <span>信息发布</span>
								</a>
								<ul>
									<li <?php echo ($active=="task") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>task/list/">-作业任务</a>
									</li>
									
									<li <?php echo ($active=="dailynews") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>dailynews/list/">-每日讯息</a>
									</li>
									
									<li <?php echo ($active=="report") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>report/list/">-学生成绩</a>
									</li>
									
									<li <?php echo ($active=="comment") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>comment/list/">-老师评语</a>
									</li>
									
									<li <?php echo ($active=="feedback") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>feedback/list/">-反馈管理</a>
									</li>								
								</ul>
							</li>
							<li class="submenu">
								<a href="#"> <span>设置</span>
								</a>
								<ul>
									<li <?php echo ($active=="setting") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>school/list/">-参数设置</a>
									</li>
									
									<li <?php echo ($active=="users") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>user/list/">-用户权限</a>
									</li>
									
									<li <?php echo ($active=="change_password") ? 'class="active"' : '';?> >
										<a href="<?php echo URL::base(NULL, TRUE)?>session/pswd/">-密码修改</a>
									</li>									
								</ul>
							</li>
						</ul>
						