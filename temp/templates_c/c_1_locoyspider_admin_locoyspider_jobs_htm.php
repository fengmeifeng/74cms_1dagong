<?php require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\modifier.cat.php'); $this->register_modifier("cat", "tpl_modifier_cat",false);  require_once('D:\fengmf\wwwroot\74cms_1dagong\include\template_lite\plugins\function.qishi_get_classify.php'); $this->register_function("qishi_get_classify", "tpl_function_qishi_get_classify",false);  /* V2.10 Template Lite 4 January 2007  (c) 2005-2007 Mark Dickenson. All rights reserved. Released LGPL. 2018-07-09 15:14 中国标准时间 */  $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_header.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
<div class="admin_main_nr_dbox">
 <div class="pagetit">
	<div class="ptit"> <?php echo $this->_vars['pageheader']; ?>
</div>
	<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("locoyspider/admin_locoyspider_nav.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
  <div class="clear"></div>
</div>
    <div class="toptip">
	<h2>提示：</h2>
	<p>火车头采集规则请到论坛下载！</p>
	</div>
	
	   <form action="?act=set_save" method="post"  name="form1" id="form1">
	   <?php echo $this->_vars['inputtoken']; ?>

	  <div class="toptit">招聘信息采集设置</div>
	   <table border="0" cellspacing="10" cellpadding="1" >
	       <tr>
        <td width="180" align="right"> 默认职位招聘状态：</td>
        <td >
		   <label><input name="jobs_display"  type="radio" value="1" <?php if ($this->_vars['show']['jobs_display'] == "1"): ?>checked="checked"<?php endif; ?> />招聘中</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		 <label><input name="jobs_display"  type="radio" value="2" <?php if ($this->_vars['show']['jobs_display'] == "2"): ?>checked="checked"<?php endif; ?> />暂停招聘</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
	       <tr>
        <td width="180" align="right"> 默认职位审核状态：</td>
        <td >
		  <label><input name="jobs_audit"  type="radio" value="1" <?php if ($this->_vars['show']['jobs_audit'] == "1"): ?>checked="checked"<?php endif; ?> />审核通过</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	    <label><input name="jobs_audit"  type="radio" value="2" <?php if ($this->_vars['show']['jobs_audit'] == "2"): ?>checked="checked"<?php endif; ?> />审核中</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		
		   <label><input name="jobs_audit"  type="radio" value="3" <?php if ($this->_vars['show']['jobs_audit'] == "3"): ?>checked="checked"<?php endif; ?> />审核未通过</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
	    
	  <tr>
        <td width="180" align="right"> 默认职位应聘邮件通知：</td>
        <td >
	
		  <label><input name="jobs_notify"  type="radio" value="1" <?php if ($this->_vars['show']['jobs_notify'] == "1"): ?>checked="checked"<?php endif; ?> />通知</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		      <label><input name="jobs_notify"  type="radio" value="0" <?php if ($this->_vars['show']['jobs_notify'] == "0"): ?>checked="checked"<?php endif; ?> />不通知</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</td>
      </tr>
	     <tr>
        <td width="180" align="right"> 职位性质无法匹配则为：</td>
        <td >
<?php echo tpl_function_qishi_get_classify(array('set' => "列表名:nature,类型:QS_jobs_nature"), $this);?>
<?php if (count((array)$this->_vars['nature'])): foreach ((array)$this->_vars['nature'] as $this->_vars['list']): ?>
<label><input type="radio" name="jobs_nature" value="<?php echo $this->_vars['list']['id']; ?>
"  <?php if ($this->_vars['show']['jobs_nature'] == $this->_vars['list']['id']): ?>checked="checked"<?php endif; ?> ><?php echo $this->_vars['list']['categoryname']; ?>
</label>
<?php endforeach; endif; ?>
</td>
      </tr>
	  <tr>
        <td width="180" align="right"> 性别无法匹配则为：</td>
        <td >
		   <label><input name="jobs_sex"  type="radio" value="1" <?php if ($this->_vars['show']['jobs_sex'] == "1"): ?>checked="checked"<?php endif; ?>/>男</label>&nbsp;&nbsp;&nbsp;
		   <label><input name="jobs_sex"  type="radio" value="2" <?php if ($this->_vars['show']['jobs_sex'] == "2"): ?>checked="checked"<?php endif; ?>/>女</label>&nbsp;&nbsp;&nbsp;
		   <label><input name="jobs_sex"  type="radio" value="0" <?php if ($this->_vars['show']['jobs_sex'] == "0"): ?>checked="checked"<?php endif; ?>/>随机<span style="color:#666666">(随机范围：男,女)</span></label>
	    </td>
      </tr>
	  <tr>
        <td width="180" align="right"> 招聘人数无法匹配则为：</td>
        <td >
 <input name="jobs_amount_min" type="text"  class="input_text_200" id="jobs_amount_min"   value="<?php echo $this->_vars['show']['jobs_amount_min']; ?>
" maxlength="3"  style="width:50px;"/>&nbsp;-&nbsp;<input name="jobs_amount_max" type="text"  class="input_text_200" id="jobs_amount_max"   value="<?php echo $this->_vars['show']['jobs_amount_max']; ?>
" maxlength="3"  style="width:50px;"/>
 随机人数</td>
      </tr>
	  <tr>
        <td width="180" align="right"> 默认有效天数：</td>
        <td >
 <input name="jobs_days_min" type="text"  class="input_text_200" id="jobs_days_min"   value="<?php echo $this->_vars['show']['jobs_days_min']; ?>
" maxlength="3"  style="width:50px;"/>&nbsp;-&nbsp;<input name="jobs_days_max" type="text"  class="input_text_200" id="jobs_days_max"   value="<?php echo $this->_vars['show']['jobs_days_max']; ?>
" maxlength="3"  style="width:50px;"/>
 随机天数
		</td>
      </tr>
	  <tr>
        <td width="180" align="right"> 默认职位分类无法匹配则为：</td>
        <td>
 
<div>
		<?php echo tpl_function_qishi_get_classify(array('set' => $this->_run_modifier("列表名:li,类型:QS_jobs,id:", 'cat', 'plugin', 1, $this->_vars['show']['jobs_category'])), $this);?>
		<input type="text" value="<?php if (count((array)$this->_vars['li'])): foreach ((array)$this->_vars['li'] as $this->_vars['list']):  if ($this->_vars['list']['id'] == $this->_vars['show']['jobs_subclass']):  echo $this->_vars['list']['categoryname'];  endif;  endforeach; endif; ?>"  readonly="readonly" name="jobs_category_cn" id="jobs_category_cn" class="input_text_200 input_text_selsect"/>
		<input name="jobs_category" id="jobs_category" type="hidden" value="<?php echo $this->_vars['show']['jobs_category']; ?>
" />
		<input name="jobs_subclass" id="jobs_subclass" type="hidden" value="<?php echo $this->_vars['show']['jobs_subclass']; ?>
" />
		<div id="menu5" class="dmenu shadow">
			<ul>
			<?php echo tpl_function_qishi_get_classify(array('set' => "列表名:jobs,类型:QS_jobs"), $this);?>
			<?php if (count((array)$this->_vars['jobs'])): foreach ((array)$this->_vars['jobs'] as $this->_vars['list']): ?>
			<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>
			<?php endforeach; endif; ?>
			</ul>
		</div>
		<div id="menu5_s" class="dmenu shadow" style="display:none"></div>
		  </div>



		</td>
      </tr>
	    <tr>
        <td align="right">工作地区无法匹配则为：</td>
        <td>
	<div>
		<?php echo tpl_function_qishi_get_classify(array('set' => "列表名:li,类型:QS_district"), $this);?>
		<input type="text" value="<?php if (count((array)$this->_vars['li'])): foreach ((array)$this->_vars['li'] as $this->_vars['list']):  if ($this->_vars['list']['id'] == $this->_vars['show']['jobs_district']):  echo $this->_vars['list']['categoryname'];  endif;  endforeach; endif; ?>"  readonly="readonly" name="jobs_district_cn" id="jobs_district_cn" class="input_text_200 input_text_selsect"/>
		<input name="sdistrict" id="sdistrict" type="hidden" value="" />
		<input name="jobs_district" id="jobs_district" type="hidden" value="<?php echo $this->_vars['show']['jobs_district']; ?>
" />
		<div id="menu6" class="dmenu shadow">
			<ul>
			<?php echo tpl_function_qishi_get_classify(array('set' => "列表名:c_province,类型:QS_district,id:0"), $this);?>
			<?php if (count((array)$this->_vars['c_province'])): foreach ((array)$this->_vars['c_province'] as $this->_vars['list']): ?>
			<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>
			<?php endforeach; endif; ?>
			</ul>
		</div>
		<div id="menu6_s" class="dmenu shadow" style="display:none"></div>
		  </div>
	</td>
      </tr>
	  <tr>
        <td align="right">学历要求无法匹配则为：</td>
        <td>
	<div>
	<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_education,列表名:li"), $this);?>
		<input type="text" value="<?php if (count((array)$this->_vars['li'])): foreach ((array)$this->_vars['li'] as $this->_vars['list']):  if ($this->_vars['list']['id'] == $this->_vars['show']['jobs_education']):  echo $this->_vars['list']['categoryname'];  endif;  endforeach; endif; ?>"  readonly="readonly" name="jobs_education_cn" id="jobs_education_cn" class="input_text_200 input_text_selsect"/>
		<input name="jobs_education" id="jobs_education" type="hidden" value="<?php echo $this->_vars['show']['jobs_education']; ?>
" />
		<div id="menu7" class="menu">
			<ul>
			<?php if (count((array)$this->_vars['li'])): foreach ((array)$this->_vars['li'] as $this->_vars['list']): ?>
			<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>
			<?php endforeach; endif; ?>
			</ul>
		</div>
		  </div>
	</td>
      </tr>
	  <tr>
        <td align="right">工作经验无法匹配则为：</td>
        <td>
 
	<div>
	<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_experience,列表名:li"), $this);?>
		<input type="text" value="<?php if (count((array)$this->_vars['li'])): foreach ((array)$this->_vars['li'] as $this->_vars['list']):  if ($this->_vars['list']['id'] == $this->_vars['show']['jobs_experience']):  echo $this->_vars['list']['categoryname'];  endif;  endforeach; endif; ?>"  readonly="readonly" name="jobs_experience_cn" id="jobs_experience_cn" class="input_text_200 input_text_selsect"/>
		<input name="jobs_experience" id="jobs_experience" type="hidden" value="<?php echo $this->_vars['show']['jobs_experience']; ?>
" />
		<div id="menu8" class="menu">
			<ul>
			<?php if (count((array)$this->_vars['li'])): foreach ((array)$this->_vars['li'] as $this->_vars['list']): ?>
			<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>
			<?php endforeach; endif; ?>
			</ul>
		</div>
		  </div>
	</td>
      </tr>
	  <tr>
        <td align="right">薪资待遇无法匹配则为：</td>
        <td>
	<div>
	<?php echo tpl_function_qishi_get_classify(array('set' => "类型:QS_wage,列表名:li"), $this);?>
		<input type="text" value="<?php if (count((array)$this->_vars['li'])): foreach ((array)$this->_vars['li'] as $this->_vars['list']):  if ($this->_vars['list']['id'] == $this->_vars['show']['jobs_wage']):  echo $this->_vars['list']['categoryname'];  endif;  endforeach; endif; ?>"  readonly="readonly" name="jobs_wage_cn" id="jobs_wage_cn" class="input_text_200 input_text_selsect"/>
		<input name="jobs_wage" id="jobs_wage" type="hidden" value="<?php echo $this->_vars['show']['jobs_wage']; ?>
" />
		<div id="menu9" class="menu">
			<ul>
			<?php if (count((array)$this->_vars['li'])): foreach ((array)$this->_vars['li'] as $this->_vars['list']): ?>
			<li id="<?php echo $this->_vars['list']['id']; ?>
" title="<?php echo $this->_vars['list']['categoryname']; ?>
"><?php echo $this->_vars['list']['categoryname']; ?>
</li>
			<?php endforeach; endif; ?>
			</ul>
		</div>
		  </div>
	
	</td>
      </tr>
	        <tr>
        <td align="right">&nbsp;</td>
        <td height="50"><span style="font-size:14px;">
          <input name="submit2222" type="submit" class="admin_submit"    value="保存修改"/>
        </span></td>
      </tr>
    </table>
	 </form>
</div>
<?php $_templatelite_tpl_vars = $this->_vars;
echo $this->_fetch_compile_include("sys/admin_footer.htm", array());
$this->_vars = $_templatelite_tpl_vars;
unset($_templatelite_tpl_vars);
 ?>
</body>
</html>