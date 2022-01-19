$(function () {
    $('#subcribe-form').unbind('submit').submit(function(e){
        e.stopPropagation();
        let data = {}
        let inps = $(this).find('input,textarea,select')
        // console.log(inps.length)
        try{
            for(let i = 0; i < inps.length; i++){
                let item = inps[i];
                data[item.name] = $(item).val()

            }
            let btn = $(this).find('[type=submit]');
            let text = btn.html();
            btn.html('Xin chờ...');
            $.ajax({
                url:$(this).attr('action'),
                type: 'POST',
                datatype:'json',
                data:data,
                success:function(rs){
                    btn.html('Gửi');
                    // console.log(rs)
                    if(rs.status){
                        $('.error_sub').text('Bạn đã gửi thông tin thành công')
                        $('#sub-email').val('');
                        // $('.pr_error').css('background', '#398439')
                    }else{
                        $('.error_sub').text(rs.errors.join("\n"))
                        // $('.pr_error').css('background', '#ed3237')
                    }
                },
                error:function(e){
                    btn.html('Gửi');
                }
            })
        }
        catch(e) {
            // console.log(e)
        }
        // console.log(data)

        return false
    })
})