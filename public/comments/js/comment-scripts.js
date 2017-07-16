jQuery(document).ready(function($){     
	
	//номерация комментариев
    $('.commentlist li').each(function(i){
        $(this).find('div.commentNumber').text('#' + (i+1));
    });

    $('#commentform').on('click', '#submit', function(e){
        e.preventDefault(); //отменяем отправку формы
        
        var comParent = $(this); //форма #commentform
        
        var wrap_result = $('.wrap_result'); //блок для вывода сообщений в всплывающем окне
        

		
		wrap_result.html('<strong>Отправка</strong>')
            .css({'color':'green'})
            //плавное появление блока
            .fadeIn(500, function(){
                //получение данных из формы
                var data = $('#commentform').serializeArray();

                $.ajax({
                    url:$('#commentform').attr('action'),
                    data: data,
                    type: 'POST',
                    datatype: 'JSON', //формат данных которые должен передать сервер
                    //токен указанный в шапке (meta) 
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                      },
                    success: function(html){
                                                                                                            
                        if(html.success){
                            wrap_result.append('<br><strong>Сохранено!</strong><br>')
                                .delay(2000) //скрываем через 2 сек

                                //Через пол секунды убрать окно и выполнить функцию
                                .fadeOut(500, function(){
                                    
                                    $('input#name, input#email, textarea#comment').val(''); //очищаем поля формы
                                    
                                    //если статус равен false(0), то не отображаем новый комментарий до модерации
                                    if(html.data.status == false) {

                                        wrap_result.html('<strong>Комментарий появится после проверки администратором</strong><br>').show(500);                                           
                                        setTimeout(function() { wrap_result.hide('slow'); }, 3000); //скрываем через 3 сек   

                                        //имитируем нажатие кнопки отмены ответа на комментарий для возврата формы вниз
                                        $('#cancel-comment-reply-link').click();                                           
                                        return;
                                    }

                                    //если это дочерний комментарий
                                    if(html.data.parent_id >0){
                                        //получаем элемент предыдущий перед формой добавления комментария
                                        comParent.parents('div#respond').prev()
                                        //вставляем после него результат вывода шаблона
                                        .after('<ul class="children">'+ html.comment + '</ul>')

                                        //если это родительский комментарий
                                    } else {
                                        //это не первый комментерий
                                        if($.contains('#comments', 'ol.commentlist')){
                                            $('ol.commentlist').append(html.comment);
                                        //самый первый комментарий
                                        } else {
                                            $('#respond').before('<div id="comments"><ol class="commentlist group">' + html.comment + '</ol></div>');
                                        }
                                    }

                                    //имитируем нажатие кнопки отмены ответа на комментарий для возврата формы вниз
                                    $('#cancel-comment-reply-link').click();
                                })


                        //Если ошибка
                        } else {
                             $('.wrap_result').css('color', 'red').append('<br><strong>Ошибка: </strong>' + html.error.join('<br>'))
                             $('.wrap_result').delay(3000).fadeOut(1000);
                        }
                    },

                    //Ошибка AJAX
                    error: function(){
                        $('.wrap_result').css('color', 'red').append('<br><strong>Ошибка!</strong>');
                        $('.wrap_result').delay(2000).fadeOut(500, function(){
                            //имитируем нажатие кнопки отмены ответа на комментарий для возврата формы вниз
                            $('#cancel-comment-reply-link').click();
                        });
                    }
                });

            })					
    });

});   
