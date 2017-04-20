<?php include('includes/head.php');?>
<?php include('includes/header.php');?>
<div class="page-content my-5">
  <div class="container">
    <h2>Faqs</h2>
	<p class="my-2">This page is to provide the users with answers to any number of commonly asked questions we have anticipated.</p>

    <div id="accordion" class="accordion my-5" role="tablist" aria-multiselectable="true">

      <div class="card my-5">
        <div class="card-header" role="tab" id="heading1">
          <h5 class="mb-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
              What does this website do?
              <i class="togglestate fa fa-chevron-down"></i>
            </a>
          </h5>
        </div>
        <div id="collapse1" class="collapse" role="tabpanel" aria-labelledby="heading1">
          <div class="card-block">
            <article>
            <p>This website has the purpose of providing a platform for students to
              collaborate on producing high quality academic papers. This is achieved
              through a system of task posting, task claiming and task completion.</p>

              <p>You can post a task by navigating to the home page and clicking the 'new task'
              button. This will open a form that will allow you to specify the nature of your task.
              After you have completed the form then you can submit it and your task will be added to our
              records. The task will then be visible on the home page to other users and on your profile page</p>

              <p>If you see a task on the home page that you wish to complete you can click into that task and view
              further details about it. Here you will see a button the says 'claim task'. If you click on this button
              then you will be given details about the implications of claiming the task. Then you can choose to submit
              the task in which case you will be able to view the task under 'claimed tasks' on your profile page.</p>

              <p>When you wish to mark your claimed task as complete you can simply navigate to the task once more and click the
              'mark as complete' button.</p>
          </article>
          </div>
        </div>
      </div>

      <div class="card my-5">
        <div class="card-header" role="tab" id="heading2">
          <h5 class="mb-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="true" aria-controls="collapse2">
              What is reputation?
              <i class="togglestate fa fa-chevron-down"></i>
            </a>
          </h5>
        </div>
        <div id="collapse2" class="collapse" role="tabpanel" aria-labelledby="heading2">
          <div class="card-block">
            <article>
            <p>Reputation is a method of rewarding or penalising users for positive or negative behaviors.
            All users begin with a reputation of 0 and there are a number of specific behaviors that result in
            a change in reputation.</p>
            <p><b>Flagging Tasks:</b> When a user flags a task this is seen as a positive for the community as a whole
            and so the user is rewarded 2 reputation points</p>
            <p><b>Claiming Tasks:</b> When a user claims a task they are rewarded 10 reputation points</p>
            <p><b>Completing Tasks:</b> When a user completes a task and the task owner feels they did a good job then
              they are awarded 5 points. Otherwise 5 points are deducted.</p>
            <p><b>Failed submission:</b> When users fail to complete a task they are deducted 30 reputation points</p>
            <p><b>Task cancellation:</b> When users cancel their claim on a task they are deducted 15 points</p>
            </article>
          </div>
        </div>
      </div>

      <div class="card my-5">
        <div class="card-header" role="tab" id="heading3">
          <h5 class="mb-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="true" aria-controls="collapse3">
              Question 3
              <i class="togglestate fa fa-chevron-down"></i>
            </a>
          </h5>
        </div>
        <div id="collapse3" class="collapse" role="tabpanel" aria-labelledby="heading3">
          <div class="card-block">
            Answer 3
          </div>
        </div>
      </div>

      <div class="card my-5">
        <div class="card-header" role="tab" id="heading4">
          <h5 class="mb-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="true" aria-controls="collapse4">
              Question 4
              <i class="togglestate fa fa-chevron-down"></i>
            </a>
          </h5>
        </div>
        <div id="collapse4" class="collapse" role="tabpanel" aria-labelledby="heading4">
          <div class="card-block">
            Answer 4
          </div>
        </div>
      </div>

      <div class="card my-5">
        <div class="card-header" role="tab" id="heading5">
          <h5 class="mb-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="true" aria-controls="collapse5">
              Question 5
              <i class="togglestate fa fa-chevron-down"></i>
            </a>
          </h5>
        </div>
        <div id="collapse5" class="collapse" role="tabpanel" aria-labelledby="heading5">
          <div class="card-block">
            Answer 5
          </div>
        </div>
      </div>

      <div class="card my-5">
        <div class="card-header" role="tab" id="heading6">
          <h5 class="mb-0">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="true" aria-controls="collapse6">
              Question 6
              <i class="togglestate fa fa-chevron-down"></i>
            </a>
          </h5>
        </div>
        <div id="collapse6" class="collapse" role="tabpanel" aria-labelledby="heading6">
          <div class="card-block">
            Answer 6
          </div>
        </div>
      </div>

    </div>
  </div>
</div>
<?php include('includes/footer.php');?>
