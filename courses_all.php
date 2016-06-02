<?php
include("header.php");
?>
<div class="container">
  <div class="pull-right">
    <h4>For Faculty</h4>
    <strong>Place items on course reserve:</strong>
    <a href="https://biblio.csusm.edu/content/course-reserves-request-form"><br/>
      Books, Articles
    </a> | 
    <a href="https://biblio.csusm.edu/content/media-request-form">
      Media
    </a> <br />
    <a href="https://biblio.csusm.edu/policies/faculty-reserve-guidelines">Faculty Reserve Guidelines</a>
  </div>
  <h1>Find Reserves by Course and Instructor</h1>
  <p><br/><a href="https://biblio.csusm.edu/reserves-faq-for-students">Reserves FAQ for students</a></p>
  <table class="table" id="coursesTable">
    <thead>
    <tr>
      
      <th>
        Course Name <i class="fa fa-sort"></i>
      </th>
      <th>
        Instructor <i class="fa fa-sort"></i>
      </th>
      <th>
        ID <i class="fa fa-sort"></i>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php include("courses_body_all.php"); ?>
</div>
<?php
include("footer.php");
?>