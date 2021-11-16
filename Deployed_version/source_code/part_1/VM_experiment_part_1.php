<!------------------ COPYRIGHT AND CONFIDENTIALITY INFORMATION  ---------------------->
<!-- Copyright © 2021 InterDigital R&D France
All Rights Reserved
Please refer to license.txt for the condition of use.
-->
<?php
ini_set("session.cookie_httponly", True);
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
var tags_right_order = <?php echo json_encode($_SESSION['$tags_right_order']); ?>;
var participant_special_id = <?php echo json_encode($_SESSION['$participant_special_id']); ?>;
var birthday = "ttt";
var country = <?php echo json_encode($_SESSION['$country']); ?>;
var gender = <?php echo json_encode($_SESSION['$gender']); ?>;

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
text: "<p>The experiment is about to start.</p>" +
    "<p>Please note that your response will be taken into account only during <br />" +
    "the display time (7 seconds) of the video. Be sure to answer quickly enough!</p>" +
    "<p>Press key 'y' to launch the experiment.</p>",
  cont_key: ['y']
};

var test_stimuli = [];
for (var i = 0;  i < definitive_urls_order.length; i++){
    test_stimuli[i] =
    {
        stimulus: '<video muted width="' + screen_width + '" height="' + screen_height + '" autoplay><source src="' + definitive_urls_order[i] + '" type="video/mp4"></video>',
        is_html: true,
        data: {
                sequence_id: parseInt(tags_right_order[i]['sequence_id']),
                video_id: parseInt(tags_right_order[i]['video_id']),
                target1_or_filler0: parseInt(tags_right_order[i]['target1_or_filler0']),
                firstoccurrence1_or_secondoccurrence2: parseInt(tags_right_order[i]['firstoccurrence1_or_secondoccurrence2']),
                video_position: parseInt(tags_right_order[i]['video_position']),
                url_name: definitive_urls_order[i]
        }
    }
}

var a4x598tg623445 = 15486652332355;
var a127z6z7e52gt3444 = <?php echo json_encode($_SESSION['$password_day2']); ?>;
var a11d2dz5dd43487541 = 67865523;
var a3896ez549rfv87d96566 = 9797546546;

var test_block = {
    type: 'single-stim',
    choices: ['space'],
    randomized_order: false,
    timing_response: 7000,
    timing_post_trial: 1000,
    response_ends_trial: true,
    on_finish: function(data){
        var correct = false;
        if(data.firstoccurrence1_or_secondoccurrence2 == 2 && data.rt > -1)
        {
            correct = true;
        } else if (data.firstoccurrence1_or_secondoccurrence2 == 1 && data.rt == -1){
            correct = true;
        }
        jsPsych.data.addDataToLastTrial({correct: correct});
    },
    timeline: test_stimuli
}

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
jsPsych.data.addProperties({
	subject: participant_special_id,
	birthday: birthday,
	country: country,
	gender: gender,
    screen_width: screen_width,
    screen_height: screen_height
});

function repeated_targets_performance() {
    var trials = jsPsych.data.getTrialsOfType('single-stim');
    trials_repeated_targets = [];
    for (var i = 0; i < trials.length; i++) {
        if ((trials[i].target1_or_filler0 == 1)&&(trials[i].firstoccurrence1_or_secondoccurrence2 == 2)) {
            trials_repeated_targets.push(trials[i]);
        }
    }
    var correct_trial_count_target = 0;
    for (var i = 0; i < trials_repeated_targets.length; i++) {
        if (trials_repeated_targets[i].correct == true) {
            correct_trial_count_target++;
        }
    }
    return {
        accuracy_targets: Math.floor(correct_trial_count_target / trials_repeated_targets.length * 100)
    }
}

function repeated_vigilance_performance(){
    var trials = jsPsych.data.getTrialsOfType('single-stim');
    trials_repeated_vigilance = [];
    for (var i = 0; i < trials.length; i++) {
        if ((trials[i].target1_or_filler0 == 0)&&(trials[i].firstoccurrence1_or_secondoccurrence2 == 2)) {
            trials_repeated_vigilance.push(trials[i]);
        }
    }
    var correct_trial_count_vigilance = 0;
    for (var i = 0; i < trials_repeated_vigilance.length; i++) {
        if (trials_repeated_vigilance[i].correct == true) {
            correct_trial_count_vigilance++;
        }
    }
    return {
        accuracy_vigilance: Math.floor(correct_trial_count_vigilance / trials_repeated_vigilance.length * 100)
    }
}

function false_alarms_rate(){
    var trials = jsPsych.data.getTrialsOfType('single-stim');
    trials_unrepeated_items = [];
    for (var i = 0; i < trials.length; i++) {
        if (trials[i].firstoccurrence1_or_secondoccurrence2 == 1) {
            trials_unrepeated_items.push(trials[i]);
        }
    }
    var correct_trial_count_FA = 0;
    for (var i = 0; i < trials_unrepeated_items.length; i++) {
        if (trials_unrepeated_items[i].correct == false) {
            correct_trial_count_FA++;
        }
    }
    return {
        FA_rate: Math.floor(correct_trial_count_FA / trials_unrepeated_items.length * 100)
    }
}

var debrief_block = {
    type: "text",
    cont_key: ['y'],
    text: function() {
        var target_result = repeated_targets_performance();
        var vigilance_result = repeated_vigilance_performance();
        var false_alarm_result = false_alarms_rate();
        if ((vigilance_result.accuracy_vigilance < 71)&&(false_alarm_result.FA_rate < 30 )) {
            return "<p>You responded only on " + vigilance_result.accuracy_vigilance + "% of the vigilant videos " +
            "intended to check your attention.</p>" +
            "<p>Consequently, you are not allowed to continue the experiment.</p>" +
            "<p>We thank you anyway for your participation to our first day experiment.</p>" +
            "<p>Press key <strong>'y'</strong> to continue.</p>";
        } else if ((false_alarm_result.FA_rate > 30 )&&(vigilance_result.accuracy_vigilance > 71)) {
            return "<p>You responded " + false_alarm_result.FA_rate + "% of the time on non-repeated videos, </p>" +
            "<p>which should no be recognized as a repetition.</p>" +
            "<p>Random responses are of no value.</p>" +
            "<p>Consequently, you are not allowed to continue the experiment.</p>" +
            "<p>We thank you anyway for your participation to our first day experiment.</p>" +
            "<p>Press key <strong>'y'</strong> to continue.</p>";
        } else if ((vigilance_result.accuracy_vigilance < 71)&&(false_alarm_result.FA_rate > 30)) {
            return "<p>You responded only on " + vigilance_result.accuracy_vigilance + "% of videos intended to check your attention.</p>" +
            "<p>You also responded " + false_alarm_result.FA_rate + "% of the time on non-repeated videos</p>" +
            "<p>Consequently, you are not allowed to continue the experiment.</p>" +
            "<p>We thank you anyway for your participation to our first day experiment.</p>" +
            "<p>Press key <strong>'y'</strong> to continue.</p>";
        } else {
            return "<p>Congratulations!<p>" +
            "<ul><li>You correctly recognized "+ target_result.accuracy_targets + "% of the repeated videos.</li>" +
            "<li>You also only responded "+ false_alarm_result.FA_rate + "% of the time on non-repeated videos.</li></ul>" +
            "<p>Please carefully note the following <strong>password</strong> to access Part 2 of the experiment:</p>" +
            "<p><strong>" + a127z6z7e52gt3444 + "</strong></p>" +
            "<p>You will definitely <strong>need this password to access Part 2 of the experiment in 24 to 72 hours from now</strong>.</p>" +
            "<p>Thank you for your valuable participation to our experiment.</p>" +
            "<br><br><p>Press key <strong>'y'</strong> to <strong>submit your results</strong> " +
            "(Wait until the blank page appears before closing any window).</p>";
        }
    }
};

/*--------------------------------------------------------------------------------------------------------------------------------------------------*/
function save_data(data){
   var data_table = "results_day1_on_table";
   $.ajax({
      type:'post',
      cache: false,
      url: 'save_day1_results_in_MySQL.php',
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