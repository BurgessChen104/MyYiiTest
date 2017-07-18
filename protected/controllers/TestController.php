<?php

class TestController extends Controller
{

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
		print_r("TEST");exit;
		//$this->render('index');
	}

	public function actionLogin()
	{
	    $model=new TestForm;
	    if(isset($_POST['LoginForm']))
	    {
	        // 收集用户输入的数据
	        $model->attributes=$_POST['LoginForm'];
	        // 验证用户输入，并在判断输入正确后重定向到前一页
	        if($model->validate())
	            $this->redirect(Yii::app()->user->returnUrl);
	    }
	    // 显示登录表单
	    $this->render('login',array('model'=>$model));
	}
}
?>