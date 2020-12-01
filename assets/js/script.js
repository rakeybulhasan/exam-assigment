$(document).ready(function(){

    $('.form_submit').on('click', function (event) {
        event.preventDefault();

        formSubmit();

    });
});
function formSubmit()
{
    var receipt_id = document.buyer_form.receipt_id;
    var amount = document.buyer_form.amount;
    var buyer = document.buyer_form.buyer;
    var items = document.buyer_form.items;
    var city = document.buyer_form.city;
    var entry_by = document.buyer_form.entry_by;
    var phone = document.buyer_form.phone;
    var uemail = document.buyer_form.buyer_email;
    var note = document.buyer_form.note;

   // return ;

        if(allNumericWithDecimal(amount,'Amount'))
        {
            if(allLetter(receipt_id,'Receipt Id'))
            {
                if(alphanumericAndWhiteSpace(buyer, "Buyer")){

                    if(allLetterAndWhiteSpace(items, "Items"))
                    {
                        if(ValidateEmail(uemail))
                        {
                             if(allLetterAndWhiteSpace(city, "City"))
                            {
                                if(allNumeric(phone, 'Phone'))
                                {
                                    if(WordCount(note, "Note"))
                                    {
                                        if(allNumeric(entry_by, 'Entry By'))
                                        {
                                            var form_element = $('#buyer_form');
                                            var data = $(form_element).serialize();
                                            $.ajax({
                                                url:"ajax-action.php",
                                                method:"POST",
                                                data: data,
                                                dataType: 'json',
                                                success:function(data)
                                                {
                                                    if(data['status']==200){
                                                        $('.alert').show().addClass('alert-success').text(data['message']);
                                                        $("#buyer_table").load(window.location + " #buyer_table");
                                                    }
                                                    if(data['status']==404){
                                                        $('.alert').show().addClass('alert-danger').text(data['message']);
                                                    }

                                                    if(data[0]){
                                                        $('.form-group').removeClass('has-error');
                                                        $('.help-block').text('');
                                                        $.each(data[0], function( index, value ) {
                                                            $('#'+index).closest('.form-group').addClass('has-error');
                                                            $('#'+index).closest('.form-group').find('.help-block').text(value);
                                                        });
                                                    }
                                                    if(data['action']!='update'){

                                                        $(form_element)[0].reset();
                                                    }
                                                },
                                                error:function (data) {
                                                    console.log(data);
                                                }
                                            })
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }

    return false;

}

function allLetter(uname, tagName)
{
    var letters = /^[A-Za-z]+$/;
    if(uname.value.match(letters))
    {
        return true;
    }
    else
    {
        alert(tagName+' must have alphabet characters only');
        uname.focus();
        return false;
    }
}

function allLetterAndWhiteSpace(uname, tagName)
{
    var letters = /^[A-Za-z' ]+$/;
    if(uname.value.match(letters))
    {
        return true;
    }
    else
    {
        alert(tagName+' must have alphabet characters and white space allowed.');
        uname.focus();
        return false;
    }
}

function alphanumeric(uadd)
{
    var letters = /^[0-9a-zA-Z]+$/;
    if(uadd.value.match(letters))
    {
        return true;
    }
    else
    {
        alert('User address must have alphanumeric characters only');
        uadd.focus();
        return false;
    }
}

function alphanumericAndWhiteSpace(uadd, tagName)
{
    var letters = /^[0-9a-zA-Z' ]+$/;
    if(uadd.value.match(letters))
    {
        return true;
    }
    else
    {
        alert(tagName+' must have alphanumeric characters and white space allowed.');
        uadd.focus();
        return false;
    }
}

function allNumeric(uzip, tagName)
{
    var numbers = /^[0-9]+$/;
    if(uzip.value.match(numbers))
    {
        return true;
    }
    else
    {
        alert(tagName+' must have numeric characters only');
        uzip.focus();
        return false;
    }
}

function allNumericWithDecimal(name, tagName)
{
    var numbers = /^[0-9]+(\.[0-9]+)?$/;
    if(name.value.match(numbers))
    {
        return true;
    }
    else
    {
        alert(tagName+' must have numeric characters only');
        name.focus();
        return false;
    }
}

function ValidateEmail(uemail)
{
    var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
    if(uemail.value.match(mailformat))
    {
        return true;
    }
    else
    {
        alert("You have entered an invalid email address!");
        uemail.focus();
        return false;
    }
}

function WordCount(note, tagName) {
    var str = note.value;
    var wordLength =  str.split(" ").length;

    if(wordLength>30){
        alert(tagName+' maximum 30 word limit');
        note.focus();
        return false;
    }
    return true;
}
