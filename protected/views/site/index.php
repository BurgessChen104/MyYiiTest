<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Hello ~ Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<p>Congratulations! You have successfully created your Yii application.</p>

<p>You may change the content of this page by modifying the following two files:</p>
<ul>
	<li>View file: <code><?php echo __FILE__; ?></code></li>
	<li>Layout file: <code><?php echo $this->getLayoutFile('main'); ?></code></li>
</ul>

<p>For more details on how to further develop this application, please read
the <a href="http://www.yiiframework.com/doc/">documentation</a>.
Feel free to ask in the <a href="http://www.yiiframework.com/forum/">forum</a>,
should you have any questions.</p>

<script>
Rollbar.configure({
  payload: {
    person: {
      id: 2644,
      username: "burgess",
      email: "burgess.chen@104.com.tw"
    }
  }
});
Rollbar.error("This is a test02 error for javascript !");

/*
window.onerror("TestRollbarError: testing window.onerror II", window.location.href);

//Rollbar.error("Something went wrong");
Rollbar.critical("Connection error from remote Payments API");
Rollbar.error("Some unexpected condition");
Rollbar.warning("Connection error from Twitter API");
Rollbar.info("User opened the purchase dialog");
Rollbar.debug("Purchase dialog finished rendering");
*/
</script>
