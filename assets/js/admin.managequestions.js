$(document).ready(function() {
    $("option[class='disabled']").attr("disabled", "disabled");

    $(".setdiv, .commit").hide();

    $(".subselect").change(function() {
        var id = $(this).find("option:selected").attr('value');
        $.post('managequestions/getSets', {subid: id}, function(data) {
            $.when($(".setdiv").hide(200)).then(function() {

                $('#getSets').empty();
                $('.setdiv .addButton').empty();

                $.each(data, function(ind, elem) {
                    $('#getSets').append(
                        $('<div>', {id: "set"+ind}).append(
                            $('<h2>', { text: elem }).append(
                                $('<a>', { class: "show btn btn-default pull-right", value: ind}).append(
                                    $('<i>', {class: "icon-plus"})
                                )
                            ),
                            $('<div>', {class: "questions"}).hide()
                        )
                    );
                });

                $('.setdiv .addButton').append(
                    $('<a>', {id: "addSet", class: "btn btn-default btn-lg", value: id, text: "Add new set"
                    })
                );

                if(data === false) $('#getSets').append($('<h2>', { text: "No available sets."}));
                $(".setdiv").show(200);
            });
        }, 'json');
    });

    $("#getSets").delegate("a.show", "click", function() {
        var id = $(this).attr('value');
        $('#set'+id).find('i').toggleClass('icon-plus icon-minus');

        $.post('managequestions/getQuestions', {setid: id}, function(data) {
            $.each(data, function(ind, elem) {
                var qid = '-1';
                $.each(elem, function(lbl, obj) {
                    switch(lbl) {
                        case 'qid':
                            qid = obj;
                            break;
                        case 'question':
                            $('#set'+id).find(".questions").append(
                                $('<h3>', {id: qid, text: obj}).append(
                                    $('<a>', { class: "edit btn btn-primary pull-right", value: qid, set: id}).append(
                                            $('<i>', {class: "icon-edit-sign"})
                                    )
                                )
                            );
                            break;
                        case 'choices':
                            $('#set'+id).find(".questions").append('<ol id='+qid+'>');
                            $.each(obj, function() {
                                $('#set'+id+' .questions').find('ol#'+qid).append($('<li>', {text: this}));
                            });
                            break;
                    }
                });
            });
            $('#set'+id).find(".questions").show(200);
        }, 'json');

        $('#set'+id).find('a').toggleClass('show hideme');
    });

    $("#getSets").delegate("a.showme", "click", function() {
        var id = $(this).attr('value');
        $('#set'+id).find('i').toggleClass('icon-plus icon-minus');
        $('#set'+id).find(".questions").show(200);
        $('#set'+id).find('a').toggleClass('showme hideme');
    });

    $("#getSets").delegate("a.hideme", "click", function() {
        var id = $(this).attr('value');
        $('#set'+id).find('i').toggleClass('icon-minus icon-plus');
        $('#set'+id).find(".questions").hide(200);
        $('#set'+id).find('a').toggleClass('hideme showme');
    });

    $("#getSets").delegate("a.edit", "click", function() {
        $('.setdiv').find('a#addSet').attr('disabled', 'disabled');
        $('.subbtn').find('a').attr('disabled', 'disabled');
        $('.subselect').attr('disabled', 'disabled');
        $(this).find('i').toggleClass('icon-edit-sign icon-check-sign');

        $('#getSets').children().each(function() {
            $(this).find('a:regex(class,hide|show)').attr('disabled', 'disabled');
        });

        var qid = $(this).attr('value');
        var sid = $(this).attr('set');
        $('#set'+sid).find('.questions h3 a').each(function() {
            if (qid != $(this).attr('value'))
                $(this).attr('disabled', 'disabled');
        });

        $('#set'+sid).find('.questions h3').each(function() {
            if (qid == $(this).find('a').attr('value')) {
                var question = $(this).text();
                $(this).replaceWith($('<div class="input-group">').append(
                    $('<input>', { type: "text", class: "form-control", value: question}),
                    $('<span class="input-group-btn">').append(
                        $(this).find('a').toggleClass("edit finish")
                    )
                ));
            }
        });

        $.post('managequestions/getCorrectAnswer', {setid: sid, questionid: qid}, function(answer) {
            console.log(answer);
            $('#set'+sid).find('.questions ol#'+qid+' li').each(function(ind, elem) {
                console.log(answer);
                console.log(ind);
            });
        }, 'json');
    });

    $(".setdiv").delegate("a#addSet", "click", function() {
        var id = $(this).attr('value');
        $('.newSets .subId').attr('value', id);
        $('.newSets .questions').append(
            $('<a>', {id: "addQuestion", class: "btn btn-default btn-lg", text: "Add a question"})
        );
        $(this).attr("id","cancelSet");
        $(this).text("Cancel");
        $(".newSets").show(200);
    });

    $(".setdiv").delegate("a#cancelSet", "click", function() {
        $(this).attr("id","addSet");
        $(this).text("Add new set");
        $('.newSets .questions').empty();
        $(".newSets").hide(200);
    });

    $(".newSets .questions").delegate("a#addQuestion", "click", function() {
        $.get("managequestions/qTemplate", function(data) {
            $(".newSets .questions:last").each(function(ind) {
                var last = parseInt($(this).find('.question:last').attr('value'), 10);
                $(this).append(data);
                if(isNaN(last)) last = 1; else last += 1;
                $(this).find('.question:last').attr('value', last);
                $(this).find('.question:last').find('input[name^="qRadio"]').attr('name', 'qRadio'+last);
                $(this).find('.question:last').show(200);
            });
        });
    });

    $('.newSets .questions').delegate("button.close", "click", function() {
        $(this).parents().each(function() {
            if($(this).hasClass('question')) {
                $.when($(this).hide(200)).then(function() {
                    $('.tooltip').remove();
                    $(this).remove();
                });
            }
        });
    });


});
