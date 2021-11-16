<!------------------ COPYRIGHT AND CONFIDENTIALITY INFORMATION  ---------------------->
<!-- Copyright © 2021 InterDigital R&D France
All Rights Reserved
Please refer to license.txt for the condition of use.
-->
<?php
ini_set('session.cookie_secure', '1');
ini_set('session.cookie_httponly', '1');
ini_set('session.use_only_cookies', '1');
session_start();
?>

<!doctype html>
<html>

<head>
    <title>My experiment</title>
    <script src="https://memorability.technicolor.com/plugin/jsquery1.11.1.js"></script>
    <script src="https://memorability.technicolor.com/plugin/jspsych-5.0.3/jspsych.js"></script>
    <script src="https://memorability.technicolor.com/plugin/jspsych-5.0.3/plugins/jspsych-text.js"></script>
    <script src="https://memorability.technicolor.com/plugin/jspsych-5.0.3/plugins/jspsych-single-stim.js"></script>
    <link href="https://memorability.technicolor.com/plugin/jspsych-5.0.3/css/jspsych.css" rel="stylesheet"></link>
</head>

<body>

</body>
<!--__________________________________________________________________________________________________________________________________________________-->
<script type="text/javascript">

/*----------------------------------------------------------------------------------------------------------------------------------------------------*/
var definitive_urls_order = <?php echo json_encode($_SESSION['$definitive_urls_order']); ?>;
var video_id = <?php echo json_encode($_SESSION['$video_id']); ?>;
var target1_or_filler0 = <?php echo json_encode($_SESSION['$target1_or_filler0']); ?>;
var occurrence = <?php echo json_encode($_SESSION['$firstoccurrence1_or_secondoccurrence2']); ?>;
// var birthday_country_gender = <?php //echo json_encode($_SESSION['$fillers_saw_once_day1']); ?>;
var video_positions = <?php echo json_encode($_SESSION['$video_positions']); ?>;
var subject = <?php echo json_encode($_SESSION['$participant_special_id']); ?>;

/*----------------------------------------------------------------------------------------------------------------------------------------------------*/
var screen_width = window.screen.availWidth;
var screen_height = window.screen.availHeight;

if ((screen_width == null)||(screen_height == null)) {
    var screen_width = 1280;
    var screen_height = 720;
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------*/
var welcome_block = {
type: "text",
text: "Welcome to the second pat of the experiment. Press any key to begin."
};

var instructions_block = {
  type: "text",
  text: "<p>During the following experiment, videos will appear at the center of the screen one after another.</p>" +
      "<p>Your task is to press the<strong>SPACE BAR</strong> whenever you recognize a video <strong>already seen during Part 1</strong></p>"+
      "<p>of the experiment that you did 24-72 hours before.</p>" +
      "<p>Again, you will have to respond <strong>during the 7-seconds display of the video</strong></p>" +
      "<p>Press key 'y' to launch the experiment.</p>",
  cont_key: ['y']
};


var test_stimuli = [];
for (var i = 0;  i < definitive_urls_order.length; i++){
    test_stimuli[i] =
    {
        stimulus: '<video muted width="' + screen_width + '" height="' + screen_height + '" autoplay><source src="' + definitive_urls_order[i] + '" type="video/mp4" preload></video>',
        is_html: true,
        data: {
                video_id: parseInt(video_id[i]),
                target1_or_filler0: parseInt(target1_or_filler0[i]),
                firstoccurrence1_or_secondoccurrence2: parseInt(occurrence[i]),
                video_position: parseInt(video_positions[i]),
                url_name: definitive_urls_order[i]
        }
    }
}

var videos_to_preload = definitive_urls_order;
var b4xb89784ff = 15486652332355;
var b4xji5864fre = <?php echo json_encode($_SESSION['$password_AMT']); ?>;
var rer46554gferge = 67865523;
var bzbfde77de786 = 9797546546;

var test_block = {
    type: 'single-stim',
    choices: ['space'],
    randomized_order: false,
    timing_response: 7000,
    timing_post_trial: 1000,
    response_ends_trial: true,

    on_finish: function(data){
        var correct = false;
        if(data.target1_or_filler0 == 1 && data.rt > -1)
        {
            correct = true;
        } else if (data.target1_or_filler0 == 0 && data.rt == -1){
            correct = true;
        }
        jsPsych.data.addDataToLastTrial({correct: correct});
        },
    timeline: test_stimuli
}

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
jsPsych.data.addProperties({
	subject: subject,
	// birthday: birthday_country_gender[0]['birthday'],
	// country: birthday_country_gender[0]['country'],
	// gender: birthday_country_gender[0]['gender'],
    screen_width: screen_width,
    screen_height: screen_height
});

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
function repeated_targets_performance() {
    var trials = jsPsych.data.getTrialsOfType('single-stim');
    trials_targets = [];
    for (var i = 0; i < trials.length; i++) {
        if (trials[i].target1_or_filler0 == 1) {
            trials_targets.push(trials[i]);
        }
    }

    var correct_trial_count_target = 0;
    for (var i = 0; i < trials_targets.length; i++) {
        if (trials_targets[i].correct == true) {
            correct_trial_count_target++;
        }
    }

    return {
        accuracy_targets: Math.floor(correct_trial_count_target / trials_targets.length * 100)
    }
}

function false_alarms_rate(){

    var trials = jsPsych.data.getTrialsOfType('single-stim');

    trials_fillers = [];
    for (var i = 0; i < trials.length; i++) {
        if (trials[i].target1_or_filler0 == 0) {
            trials_fillers.push(trials[i]);
        }
    }

    var incorrect_trial_count_FA = 0;
    for (var i = 0; i < trials_fillers.length; i++) {
        if (trials_fillers[i].correct == false) {
            incorrect_trial_count_FA++;
        }
    }

    return {
        FA_rate: Math.floor(incorrect_trial_count_FA / trials_fillers.length * 100)
    }
}

var debrief_block = {
    type: "text",
	cont_key: ['y'],
    text: function() {
        var target_result = repeated_targets_performance();
        var false_alarm_result = false_alarms_rate();
        if (target_result.accuracy_targets < 15) {
        	return "<p>You responded only on " + target_result.accuracy_targets + "% of the videos viewed during Part 1 of the experiment.</p>" +
        	"<p>It is <strong>not better than the hasard</strong>.</P>" + 
            "<p>Consequently, you are not allowed to continue the experiment.</p>" +
            "<p>We thank you anyway for your participation to our experiment.</p>" +
        	"<p>Press key 'y' to continue.</p>";
        } else if ((target_result.accuracy_targets > 15)&&(false_alarm_result.FA_rate >= target_result.accuracy_targets)) {
        	return "<p>Your incorrect responses rate: " + false_alarm_result.FA_rate + ", is higher than your correct<br /> " +
        	"responses rate: " + target_result.accuracy_targets + ".</p>" +
            "<p>Consequently, you are not allowed to continue the experiment.</p>" +
            "<p>We thank you anyway for your participation to our experiment.</p>" +
            "<p>Press key 'y' to continue.</p>";
        } else if (false_alarm_result.FA_rate >=40) {
        	return "<p>Your incorrect responses rate: " + false_alarm_result.FA_rate + ", is incredibly high.</p>" +
            "<p>Consequently, you are not allowed to continue the experiment.</p>" +
            "<p>We thank you anyway for your participation to our experiment.</p>" +
         	"<p>Press key 'y' to continue.</p>";
        } else {
            return "<p>Congratulations!<p>" +
            "<ul><li>You correctly recognized " + target_result.accuracy_targets + "% of the repeated videos.</li>" +
            "<li>You also only responded " + false_alarm_result.FA_rate + "% of the time on non-repeated videos.</li></ul>" +
            "<p>Please enter the following <strong>password</strong> in the Amazon Mechanical Turk webpage to be paid:</p>" +
            "<p><strong>" + b4xji5864fre + "</strong></p>" +
            "<p>You will be payed once we have gone through the normal control process.</p>" +
            "<p>Thank you for your valuable participation to our experiment.</p>" +
            "<br><br><p>Press key <strong>'y'</strong> to <strong>submit your results</strong> " +
            "(Wait until the blank page appears before closing the windows).</p>";
        }
    }
};

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
function save_data(data){
   var data_table = "results_day2_on_table";
   $.ajax({
      type:'post',
      cache: false,
      url: 'save_day2_results_in_MySQL.php',
      data: {
          table: data_table,
          json: JSON.stringify(data),
      },
      success: function(output) { console.log(output); }
   });
}

/*__________________________________________________________________________________________________________________________________________________*/
var timeline = [];
	timeline.push(welcome_block);
	timeline.push(instructions_block);
	timeline.push(test_block);
	timeline.push(debrief_block);

/*__________________________________________________________________________________________________________________________________________________*/
jsPsych.init({
    timeline: timeline,
    fullscreen: true,
    auto_preload: false,
    on_finish: function(data) { save_data(data) }
});

/*---------------------------------------------------------------------------------------------------------------------------------------------------*/
</script>
</html>