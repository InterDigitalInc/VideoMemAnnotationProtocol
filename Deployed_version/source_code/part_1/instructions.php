<!------------------ COPYRIGHT AND CONFIDENTIALITY INFORMATION  ---------------------->
<!-- Copyright © 2021 InterDigital R&D France
All Rights Reserved
Please refer to license.txt for the condition of use.
-->
<!DOCTYPE html>
<html>
    <head>
        <script src="https://memorability.technicolor.com/plugin/jsPsych-master/jspsych.js"></script>
        <script src="https://memorability.technicolor.com/plugin/jsPsych-master/plugins/jspsych-instructions.js"></script>
        <script src="https://memorability.technicolor.com/plugin/jsPsych-master/plugins/jspsych-video.js"></script>
        <link rel="stylesheet" href="../plugin/jsPsych-master/css/jspsych.css">
    </head>
<body>
</body>

<script>
/*----------------------------------------------------------------------------------------------------------------------------------------------------*/
// CREATE THE STIMULI
/*----------------------------------------------------------------------------------------------------------------------------------------------------*/

//INSTRUCTIONS STIM
var instructions_block = {       
    type: 'instructions',     
    pages: [      
    '<p><strong>First part of the experiment:</strong></p>' +
    '<p>You will see a series of videos, displayed one after another.</p>' +
    '<p>Some videos will be repeated after a period of time.</p>' +
    '<p>Your task is to press the "SPACEBAR" when the current video has already been shown.</p>',     
        
    'Here is an example:<br><br> ' +
    '<video width="854" height="480" controls autoplay><source src="../videos/video5650.webm" type="video/webm"></video><br><br>' +       
    'Imagine you see this video for the first time: you don\'t have to press the spacebar yet...',

    '<video width="854" height="480" controls autoplay><source src="../videos/video2821.webm" type="video/webm"></video><br><br>' +       
    'You also see this video for the first time: do not press the spacebar.<br><br>',

    '<video width="854" height="480" controls autoplay><source src="../videos/video5650.webm" type="video/webm"></video><br><br>' +       
    'You have already seen this video: Press the spacebar :)',

    'Note that the delay before the repetition of a video may vary from seconds to minutes.<br />'+
    'Please do not worry if you detect no repeated videos for some time.',

    'The experiment lasts about 20 minutes in a row and you won\'t be able <br />' +
    'to stop it for a break.' +
    'Please be sure to be available for the entire duration before starting.'
    ],        
    show_clickable_nav: true      
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------*/
function redirect() {
    //redirect to php page
    window.location.replace("VM_experiment_part_1.php");
}

/*----------------------------------------------------------------------------------------------------------------------------------------------------*/
jsPsych.init({      
        timeline: [instructions_block],
        on_finish: function() { redirect(); }
});

/*----------------------------------------------------------------------------------------------------------------------------------------------------*/
</script>
</html>