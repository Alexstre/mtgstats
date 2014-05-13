$(document).ready(function ( $ ) {
    $('#scoreupdates').on('submit', function () {
        /* loading text would be here if needed */
        $.post(
            $(this).prop('action'), {
                "deck_id1": $('#deck1').val(),
                "deck_id2": $('#deck2').val(),
                "score1": $('#score1').val(),
                "score2": $('#score2').val(),
                "eventid": $('#eventid').val()
            },
            function (data) {
                console.log(data);
            }, 'json'
        );

        /* anything else? */
        return false; // prevents the browser submit
    });

    $('#finishupdates').click(function (event) {
        event.preventDefault();
        var finishdata = $('#finishes').serialize();
        console.log(finishdata);
        $.ajax({
            type: "POST",
            url: "/result/create",
            data: finishdata,
            success: function(data) {
                location.reload();
            }
        });
    });

    // end of JS bullshit
});