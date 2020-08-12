<!DOCTYPE html>

<html>
<head>
    <title>Laravel7 CRUD</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="http://ajax.microsoft.com/ajax/jquery.validate/1.7/jquery.validate.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.15.0/additional-methods.js"></script>
    <style>
        .error{
            display:none;
            color: red
        }
    </style>
</head>
<body>
<div class="container">
    @yield('content')
</div>
</body>
<script>
    $(document).ready(function () {
        $( "#datepicker" ).datepicker({
            dateFormat: "yy-mm-dd"
        });

        /* When click New customer button */
        $('#new-customer').click(function (ev) {
            ev.preventDefault();
            $('#btn-save').val("create-customer");
            $('#customer').trigger("reset");
            $('#customerCrudModal').html("Add New Customer");
            $('#crud-modal').modal('show');
        });

        /* Edit customer */
        $('body').on('click', '#edit-customer', function (ev) {
            ev.preventDefault();
            var customer_id = $(this).data('id');
            $.get('customers/' + customer_id + '/edit', function (data) {
                $('#customerCrudModal').html("Edit customer");
                $('#btn-update').val("Update");
                $('#btn-save').prop('disabled', false);
                $('#crud-modal').modal('show');
                $('#cust_id').val(data.id);
                $('#name').val(data.name);
                $('#country').val(data.country_id);
                $.each(data.cities, function(key, value) {
                    $('#city')
                        .append($("<option></option>")
                            .attr("value", value.id)
                            .text(value.name));
                });
                $('#city').val(data.city_id);
                $('#hidden_resume').val(data.resume);
                var lang_skills = data.lang_skills.split(',');

                console.log(lang_skills)
                $("#skill_div").children(":input").each(function(){
                    var value_name = $(this).attr('value');
                    var skill_value = '';
                    $.each(lang_skills, function( index, value ) {
                        if(value_name == value){
                            skill_value = value_name;
                        }
                    });
                    if(skill_value == value_name){
                        $(this).attr('checked','checked');
                    }else{
                        $(this).attr('checked',false);
                    }

                });
                $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd' });
                $('#datepicker').datepicker('setDate', new Date(data.date_of_birth));

            })
        });
        /* Show customer */
        $('body').on('click', '#show-customer', function () {
            $('#customerCrudModal-show').html("Customer Details");
            $('#crud-modal-show').modal('show');
        });

        /* Delete customer */
        $('body').on('click', '#delete-customer', function () {
            var customer_id = $(this).data("id");
            var token = $("meta[name='csrf-token']").attr("content");

            var r = confirm("Are You sure want to delete !");
            if (r == true) {
                $.ajax({
                    type: "DELETE",
                    url: "<?php echo URL::to('/') . '/customers/';?>" + customer_id,
                    data: {
                        "id": customer_id,
                        "_token": token,
                    },
                    success: function (data) {
                        $('#msg').html('Customer entry deleted successfully');
                        $("#customer_id_" + customer_id).remove();
                    },
                    error: function (data) {
                        console.log('Error:', data);
                    }
                });
            }
        });
        $('#country').change(function(){
            var countryID = $(this).val();
            if(countryID){
                $.ajax({
                    type:"GET",
                    url:"{{url('get-city-list')}}?country_id="+countryID,
                    success:function(res){
                        if(res){
                            $("#city").empty();
                            $("#city").append('<option>Select City</option>');
                            $.each(res,function(key,value){
                                $("#city").append('<option value="'+key+'">'+value+'</option>');
                            });

                        }else{
                            $("#city").empty();
                        }
                    }
                });
            }else{
                $("#state").empty();
                $("#city").empty();
            }
        });
        $('#btn-save').on('click', function(e) {
            e.preventDefault();
            var error=0;
            $("#nameError").html("");
            if($('#name').val() == ''){
                error++;
                $("#nameError").show()
                $("#nameError").html("Please write a name");
            }
            $("#countryError").html("");
            console.log($('#country'))
            if($('#country').val() == ''){
                error++;
                $("#countryError").show()
                $("#countryError").text("Please select a country");
            }
            $("#cityError").html("");
            if($('#city').val() == ''){
                error++;
                $("#cityError").show()
                $("#cityError").text("Please select a city");
            }
            $("#date_of_birthError").html("");
            if($('#date_of_birth').val() == ''){
                error++;
                $("#date_of_birthError").show()
                $("#date_of_birthError").text("Please select date_of_birth");
            }
            var checked_skill = 0;
            var checked_skill_name = '';
            $("#skillError").html("");
            $("#skill_div").children(":input").each(function(){
                if($(this).filter(':checked').length > 0)
                {
                    checked_skill_name += $(this).attr('value')+',';
                    checked_skill++;
                }
            });
            if(checked_skill == 0){
                error++;
                $("#skillError").show()
                $("#skillError").text("Please select at least one skill");
            }

            var datastring = $("#custForm").serialize();
            var token = $("#token").val();
            /**Ajax code**/
            var formData = new FormData($("#custForm")[0]);
            if(error == 0){
                $('#lang_skills').val(checked_skill_name)
                $.ajax({
                    type: "post",
                    url: "{{url('verifydata')}}",
                    data: formData,
                    contentType: false,
                    cache: false,
                    processData: false
                })
                    .done(function( data ) {
                        $("#fileError").hide();
                        $("#custForm").submit();
                        // do something nice, the response was successful
                    })
                    .fail(function(jqXHR, textStatus, errorThrown) {
                        var data = JSON.parse(jqXHR.responseText);
                        $("#date_of_birthError").hide()
                        if(data.errors.date_of_birth){
                            $("#date_of_birthError").show()
                            $("#date_of_birthError").text(data.errors.date_of_birth);
                        }
                        $("#fileError").hide()
                        if(data.errors.resume){
                            $("#fileError").show()
                            $("#fileError").text(data.errors.resume);
                        }
                    });
            }

            /*$.ajax({
                type: "POST",
                url: host+'/comment/add',
                data: {name:name, message:message, post_id:postid},
                success: function( msg ) {
                    alert( msg );
                }
            });*/
        });

    });
    function readURL(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.readAsDataURL(input.files[0]);
        }
    }

</script>
</html>