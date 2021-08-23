<!DOCTYPE html>
<html lang="en">

<head>
  <title>Outcome Based Education : ClassConnect</title>
  <?php require('../css.php'); ?>
</head>

<body>
  <div class="content">
    <div class="container-fluid moduleBody">
      <div class="row">
        <div class="col-2 p-0 m-0 pl-2 full-height">
          <h5 class="mt-3">Open Access</h5>
          <div class="list-group list-group-mine mt-2" id="list-tab" role="tablist">
            <a class="list-group-item list-group-item-action active btl" id="list-btl-list" data-toggle="list" href="#list-btl" role="tab" aria-controls="btl"> Bloom's Taxonomy Lavel </a>
            <a class="list-group-item list-group-item-action ap" id="list-ap-list" data-toggle="list" href="#list-ap" role="tab" aria-controls="ap"> Assessment Plan </a>
          </div>
        </div>
        <div class="col-10 leftLinkBody">
          <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane show active" id="list-btl" role="tabpanel">
              <div class="row">
                <div class="col-9 mt-1 mb-1">
                  <div class="container card mt-2 myCard">
                    <form class="form-horizontal" id="atmpForm">
                      <div class="row mt-2">
                        <div class="col-3">
                          <label> Bloom's Taxonomy Level </label>
                          <p id="btLevel"></p>
                        </div>
                      </div>
                    </form>
                  </div>
                  <div class="container card mt-2 myCard">
                    <div>
                      The following is a list of measurable action verbs that can be used when you are creating your learning objectives. Keep in mind that the goal is not to use different or creative verbs for each objective. That could be confusing to your students. Instead, try and identify the most accurate verb that relates to how you will assess your student&#8217;s mastery of the objective. For more about using Bloom&#8217;s Taxonomy in your classroom, please see: <a href="https://tips.uark.edu/using-blooms-taxonomy/">tips.uark.edu/using-blooms-taxonomy/</a>
                      <strong>TIPS tip:</strong> If you know what verb you want to use, but you are needing to know the Bloom&#8217;s level, you can use the &#8220;find&#8221; function (press: Ctrl-F, or Command-F on a Mac) in your browser to locate specific verbs on this chart
                      <table border="1" cellspacing="0" cellpadding="5">
                        <tbody>
                          <tr>
                            <th valign="middle" bgcolor="#E4E4E4" height="50"><strong style="font-size: 1.2em;">Remember</strong></th>
                            <th valign="middle" bgcolor="#E4E4E4" height="50"><strong style="font-size: 1.2em;">Understand</strong></th>
                            <th valign="middle" bgcolor="#E4E4E4" height="50"><strong style="font-size: 1.2em;">Apply</strong></th>
                            <th valign="middle" bgcolor="#E4E4E4" height="50"><strong style="font-size: 1.2em;">Analyze</strong></th>
                            <th valign="middle" bgcolor="#E4E4E4" height="50"><strong style="font-size: 1.2em;">Evaluate</strong></th>
                            <th valign="middle" bgcolor="#E4E4E4" height="50"><strong style="font-size: 1.2em;">Create</strong></th>
                          </tr>
                          <tr>
                            <td>Cite</td>
                            <td>Add</td>
                            <td>Acquire</td>
                            <td> Analyze</td>
                            <td>Appraise</td>
                            <td>Abstract</td>
                          </tr>
                          <tr>
                            <td>Define</td>
                            <td>Approximate</td>
                            <td>Adapt</td>
                            <td>Audit</td>
                            <td>Assess</td>
                            <td>Animate</td>
                          </tr>
                          <tr>
                            <td>Describe</td>
                            <td>Articulate</td>
                            <td>Allocate</td>
                            <td>Blueprint</td>
                            <td>Compare</td>
                            <td>Arrange</td>
                          </tr>
                          <tr>
                            <td>Draw</td>
                            <td>Associate</td>
                            <td>Alphabetize</td>
                            <td>Breadboard</td>
                            <td>Conclude</td>
                            <td>Assemble</td>
                          </tr>
                          <tr>
                            <td>Enumerate</td>
                            <td>Characterize</td>
                            <td>Apply</td>
                            <td>Break down</td>
                            <td>Contrast</td>
                            <td>Budget</td>
                          </tr>
                          <tr>
                            <td>Identify</td>
                            <td>Clarify</td>
                            <td>Ascertain</td>
                            <td>Characterize</td>
                            <td>Counsel</td>
                            <td>Categorize</td>
                          </tr>
                          <tr>
                            <td>Index</td>
                            <td>Classify</td>
                            <td>Assign</td>
                            <td>Classify</td>
                            <td>Criticize</td>
                            <td>Code</td>
                          </tr>
                          <tr>
                            <td>Indicate</td>
                            <td>Compare</td>
                            <td>Attain</td>
                            <td>Compare</td>
                            <td>Critique</td>
                            <td>Combine</td>
                          </tr>
                          <tr>
                            <td>Label</td>
                            <td>Compute</td>
                            <td>Avoid</td>
                            <td>Confirm</td>
                            <td>Defend</td>
                            <td>Compile</td>
                          </tr>
                          <tr>
                            <td>List</td>
                            <td>Contrast</td>
                            <td>Back up</td>
                            <td>Contrast</td>
                            <td>Determine</td>
                            <td>Compose</td>
                          </tr>
                          <tr>
                            <td>Match</td>
                            <td>Convert</td>
                            <td>Calculate</td>
                            <td>Correlate</td>
                            <td>Discriminate</td>
                            <td>Construct</td>
                          </tr>
                          <tr>
                            <td>Meet</td>
                            <td>Defend</td>
                            <td>Capture</td>
                            <td>Detect</td>
                            <td>Estimate</td>
                            <td>Cope</td>
                          </tr>
                          <tr>
                            <td>Name</td>
                            <td>Describe</td>
                            <td>Change</td>
                            <td>Diagnose</td>
                            <td>Evaluate</td>
                            <td>Correspond</td>
                          </tr>
                          <tr>
                            <td>Outline</td>
                            <td>Detail</td>
                            <td>Classify</td>
                            <td>Diagram</td>
                            <td>Explain</td>
                            <td>Create</td>
                          </tr>
                          <tr>
                            <td>Point</td>
                            <td>Differentiate</td>
                            <td>Complete</td>
                            <td>Differentiate</td>
                            <td>Grade</td>
                            <td>Cultivate</td>
                          </tr>
                          <tr>
                            <td>Quote</td>
                            <td>Discuss</td>
                            <td>Compute</td>
                            <td>Discriminate</td>
                            <td>Hire</td>
                            <td>Debug</td>
                          </tr>
                          <tr>
                            <td>Read</td>
                            <td>Distinguish</td>
                            <td>Construct</td>
                            <td>Dissect</td>
                            <td>Interpret</td>
                            <td>Depict</td>
                          </tr>
                          <tr>
                            <td>Recall</td>
                            <td>Elaborate</td>
                            <td>Customize</td>
                            <td>Distinguish</td>
                            <td>Judge</td>
                            <td>Design</td>
                          </tr>
                          <tr>
                            <td>Recite</td>
                            <td>Estimate</td>
                            <td>Demonstrate</td>
                            <td>Document</td>
                            <td>Justify</td>
                            <td>Develop</td>
                          </tr>
                          <tr>
                            <td>Recognize</td>
                            <td>Example</td>
                            <td>Depreciate</td>
                            <td>Ensure</td>
                            <td>Measure</td>
                            <td>Devise</td>
                          </tr>
                          <tr>
                            <td>Record</td>
                            <td>Explain</td>
                            <td>Derive</td>
                            <td>Examine</td>
                            <td>Predict</td>
                            <td>Dictate</td>
                          </tr>
                          <tr>
                            <td>Repeat</td>
                            <td>Express</td>
                            <td>Determine</td>
                            <td>Explain</td>
                            <td>Prescribe</td>
                            <td>Enhance</td>
                          </tr>
                          <tr>
                            <td>Reproduce</td>
                            <td>Extend</td>
                            <td>Diminish</td>
                            <td>Explore</td>
                            <td>Rank</td>
                            <td>Explain</td>
                          </tr>
                          <tr>
                            <td>Review</td>
                            <td>Extrapolate</td>
                            <td>Discover</td>
                            <td>Figure out</td>
                            <td>Rate</td>
                            <td>Facilitate</td>
                          </tr>
                          <tr>
                            <td>Select</td>
                            <td>Factor</td>
                            <td>Draw</td>
                            <td>File</td>
                            <td>Recommend</td>
                            <td>Format</td>
                          </tr>
                          <tr>
                            <td>State</td>
                            <td>Generalize</td>
                            <td>Employ</td>
                            <td>Group</td>
                            <td>Release</td>
                            <td>Formulate</td>
                          </tr>
                          <tr>
                            <td>Study</td>
                            <td>Give</td>
                            <td>Examine</td>
                            <td>Identify</td>
                            <td>Select</td>
                            <td>Generalize</td>
                          </tr>
                          <tr>
                            <td>Tabulate</td>
                            <td>Infer</td>
                            <td>Exercise</td>
                            <td>Illustrate</td>
                            <td>Summarize</td>
                            <td>Generate</td>
                          </tr>
                          <tr>
                            <td>Trace</td>
                            <td>Interact</td>
                            <td>Explore</td>
                            <td>Infer</td>
                            <td>Support</td>
                            <td>Handle</td>
                          </tr>
                          <tr>
                            <td>Write</td>
                            <td>Interpolate</td>
                            <td>Expose</td>
                            <td>Interrupt</td>
                            <td>Test</td>
                            <td>Import</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Interpret</td>
                            <td>Express</td>
                            <td>Inventory</td>
                            <td>Validate</td>
                            <td>Improve</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Observe</td>
                            <td>Factor</td>
                            <td>Investigate</td>
                            <td>Verify</td>
                            <td>Incorporate</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Paraphrase</td>
                            <td>Figure</td>
                            <td>Layout</td>
                            <td></td>
                            <td>Integrate</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Picture graphically</td>
                            <td>Graph</td>
                            <td>Manage</td>
                            <td></td>
                            <td>Interface</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Predict</td>
                            <td>Handle</td>
                            <td>Maximize</td>
                            <td></td>
                            <td>Join</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Review</td>
                            <td>Illustrate</td>
                            <td>Minimize</td>
                            <td></td>
                            <td>Lecture</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Rewrite</td>
                            <td>Interconvert</td>
                            <td>Optimize</td>
                            <td></td>
                            <td>Model</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Subtract</td>
                            <td>Investigate</td>
                            <td>Order</td>
                            <td></td>
                            <td>Modify</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Summarize</td>
                            <td>Manipulate</td>
                            <td>Outline</td>
                            <td></td>
                            <td>Network</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Translate</td>
                            <td>Modify</td>
                            <td>Point out</td>
                            <td></td>
                            <td>Organize</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td>Visualize</td>
                            <td>Operate</td>
                            <td>Prioritize</td>
                            <td></td>
                            <td>Outline</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Personalize</td>
                            <td>Proofread</td>
                            <td></td>
                            <td>Overhaul</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Plot</td>
                            <td>Query</td>
                            <td></td>
                            <td>Plan</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Practice</td>
                            <td>Relate</td>
                            <td></td>
                            <td>Portray</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Predict</td>
                            <td>Select</td>
                            <td></td>
                            <td>Prepare</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Prepare</td>
                            <td>Separate</td>
                            <td></td>
                            <td>Prescribe</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Price</td>
                            <td>Subdivide</td>
                            <td></td>
                            <td>Produce</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Process</td>
                            <td>Train</td>
                            <td></td>
                            <td>Program</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Produce</td>
                            <td>Transform</td>
                            <td></td>
                            <td>Rearrange</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Project</td>
                            <td></td>
                            <td></td>
                            <td>Reconstruct</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Provide</td>
                            <td></td>
                            <td></td>
                            <td>Relate</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Relate</td>
                            <td></td>
                            <td></td>
                            <td>Reorganize</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Round off</td>
                            <td></td>
                            <td></td>
                            <td>Revise</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Sequence</td>
                            <td></td>
                            <td></td>
                            <td>Rewrite</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Show</td>
                            <td></td>
                            <td></td>
                            <td>Specify</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Simulate</td>
                            <td></td>
                            <td></td>
                            <td>Summarize</td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Sketch</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Solve</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Subscribe</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Tabulate</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Transcribe</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Translate</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                          <tr>
                            <td></td>
                            <td></td>
                            <td>Use</td>
                            <td></td>
                            <td></td>
                            <td></td>
                          </tr>
                        </tbody>
                      </table>
                      <p>&nbsp;</p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="tab-pane" id="list-ap" role="tabpanel">
              <div class="row">
                <div class="col-6 mt-1 mb-1">
                  <div class="container card mt-2 myCard">
                    <ul class="nav nav-pills mb-3 shadow-sm" id="pills-tab" role="tablist">
                      <li class="nav-item">
                        <a class="nav-link active" data-toggle="pill" href="#pills_template" role="tab">Template</a>
                      </li>
                      <li class="nav-item">
                        <a class="nav-link assessments" data-toggle="pill" href="#pills_assessments" role="tab">Assessments</a>
                      </li>
                    </ul>
                    <!-- content -->
                    <div class="tab-content" id="pills-tabContent p-3">
                      <div class="tab-pane fade show active" id="pills_template" role="tabpanel">
                        <table class="table table-bordered table-striped list-table-xs" id="subjectTemplate">
                          <tr>
                            <th>Template</th>
                            <th>Components</th>
                          </tr>
                        </table>
                      </div>
                      <div class="tab-pane fade" id="pills_assessments" role="tabpanel">
                        <label>Template-<span id="saTemplate"></span></label>
                        <table class="table table-bordered table-striped list-table-xs" id="assessmentComponentTable">
                          <tr>
                            <th>#</th>
                            <th>Components</th>
                            <th>Weightage (%)</th>
                            <th>Assessments</th>
                            <th>Consider</th>
                          </tr>
                        </table>
                      </div>
                    </div>
                  </div>
                  <div class="container card mt-2 myCard">
                    <table class="table table-bordered table-striped list-table-xs mt-3" id="myLoadTable">
                      <tr>
                        <th><i class="fa fa-pencil-alt"></i></th>
                        <th>#</th>
                        <th>Class</th>
                        <th>Grp</th>
                        <th>Code</th>
                        <th>Name</th>
                      </tr>
                    </table>
                  </div>
                </div>
                <div class="col-5 mt-1 mb-1">Assessment Summary
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
  $(document).ready(function() {
    const myJSON = '{"name":"John", "age":30, "Remember":["who", "what", "why", "when", "omit", "where", "which", "choose", "find", "how", "define", "label", "show", "spell", "list", "match", "name", "relate", "tell", "recall", "select"], "Understand":["Add", "Approximate", "Articulate", "Associate", "omit", "where", "which", "choose", "find", "how", "define", "label", "show", "spell", "list", "match", "name", "relate", "tell", "recall", "select"]}';
    const myObj = JSON.parse(myJSON);

    document.getElementById("btLevel").innerHTML = myObj.Understand[0];

    function getFormattedDate(ts, fmt) {
      var a = new Date(ts);
      var day = a.getDate();
      var month = a.getMonth() + 1;
      var year = a.getFullYear();
      var date = day + '-' + month + '-' + year;
      var dateYmd = year + '-' + month + '-' + day;
      if (fmt == "dmY") return date;
      else return dateYmd;
    }
  });
</script>

</html>