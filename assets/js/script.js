/**
 * Created by blues on 7/9/14.
 */
$(document).ready(function(){
    $('.blur-background').hide();
    $('.stat').click(function(){
        $('.blur-background').show();
        $.ajax({
            url: "../admin/stat/get_first_date",
            data: { pro: 1 },
            type: "POST",
            error: function(error){
                alert('errr');
            },
            success: function(data){
                dateObj = new Date();
                var month = dateObj.getUTCMonth();
                var day = dateObj.getUTCDate();
                var year = dateObj.getUTCFullYear();
            }
        });
    });
    $('.stat-close-btn').click(function(){
        $('.blur-background').hide();
    });


});