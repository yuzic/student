(function( $ ) {
	$.fn.userManager = function(settings) {
		var options = $.extend({
            selectorContainer:'',
			createUserRoute: '',
			updateUserRoute: '',
            listUserRoute: '',
            deleteUserRoute: '',
			deleteFileRoute: '',
            createUserRatingRoute: '',
            createUserTopRatingRoute: '',
            userRatingContainer:'#user-rating-container',
            directoryId: 1,
            historyNaviagation:[]
		}, settings);
		
		return this.each(function() {

			var self = $(this);
            // create user
			$(document).on('click', '.add-user-button', function(){
                createUser();
		    });

            $(document).on('click', '.user-list', function(){
                userList();
            });

              // delete user
            $(document).on('click', '.user-delete', function() {
                var elementSelector = $(this).parents('tr');
                deleteUser(elementSelector.attr('userId'));
            });

            // sumbit form student
            $(document).on('submit', '#registration-form', function(e) {
                e.preventDefault();
                submitUserForm('#registration-form');
            });
            // form rating
            $(document).on('submit', '#subject-form', function(e) {
                e.preventDefault();
                submitRatingForm('#subject-form');
            });

            // rating top 10
            $(document).on('click', '.user-top-rating', function() {
                createUserTopRating();
            });

            // add rating user
            $(document).on('click', '.user-add-rating', function() {
                var elementSelector = $(this).parents('tr');
                createUserRating(elementSelector.attr('userId'));
            });

            function submitUserForm(formId) {
                var params = $(formId).serializeArray();
                var jsonData = {};
                $.each(params, function() {
                    jsonData[this.name] = this.value;
                });
                return $.ajax({
                    url:'/admin/add',
                    type: "POST",
                    async:true,
                    data: 'request='+JSON.stringify(jsonData)
                }).success(function(data){
                        var data = JSON.parse(data);
                        if (data.status == 'ok'){
                            $(formId).html('Успешно добавлен!');
                            console.log(data.message);
                           // $('#cForm').html(data.message);
                        }
                    }
                );
            };

            function submitRatingForm(formId) {
                var params = $(formId).serializeArray();
                var jsonData = {};
                $.each(params, function() {
                    jsonData[this.name] = this.value;
                });
                return $.ajax({
                    url:options.createUserRatingRoute,
                    type: "POST",
                    async:true,
                    data: 'request='+JSON.stringify(jsonData)
                }).success(function(data){
                        var data = JSON.parse(data);
                        if (data.status == 'ok'){
                            $(formId).html('Успешно добавлен!');

                            // $('#cForm').html(data.message);
                        }
                    }
                );
            };

            function createUserRating(userId){
                var data={};
                data['userId'] = userId;
                $.ajax(options.createUserRatingRoute, {
                    type: "POST",
                    dataType: 'html',
                    data: data,
                    success: function(data) {
                        $(options.userRatingContainer).html(data);
                    },
                    error: function() {
                        console.log('failed create firecory');
                    }
                });
            }

            function createUserTopRating(){
                var data={};
                $.ajax(options.createUserTopRatingRoute, {
                    type: "POST",
                    dataType: 'html',
                    data: data,
                    success: function(data) {
                        $(options.userRatingContainer).html(data);
                    },
                    error: function() {
                        console.log('failed create firecory');
                    }
                });
            }

            function createUser(){
                   var data={};
                   $.ajax(options.createUserRoute, {
                       type: "POST",
                       dataType: 'html',
                       data: data,
                       success: function(data) {
                           $(options.selectorContainer).html(data);
                       },
                       error: function() {
                           console.log('failed create firecory');
                       }
                   });

            };

            function userList(){
                var data = {};
                $.ajax(options.listUserRoute, {
                    type: "POST",
                    dataType: 'html',
                    data: data,
                    success: function(data) {
                        $(options.selectorContainer).html(data);
                    },
                    error: function() {
                        console.log('failed to get list from directory');
                    }
                });
            }
			


			function deleteUser(id) {
				var data = {};
				data['id'] = id;
				$.ajax(options.deleteUserRoute, {
	    	  		 type: "POST",
	    	  		 dataType: 'json', 
	    	  		 data: data,
	    	  		 success: function(response) {
	    	  			 if (response) {
	    	  				 $('#preload_' + id).remove();
	    	  			 }  
	    	  		 },
                    error: function() {
                        console.log('failed to delete file');
                    }
	    	  	 });
		    };	
		    

		});
	};
}(jQuery));
