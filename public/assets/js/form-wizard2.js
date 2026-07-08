$(function () {
	'use strict';

	const csrfToken = $('meta[name="csrf-token"]').attr('content');

	$.ajaxSetup({
		headers: {
			'X-CSRF-TOKEN': csrfToken
		}
	});

	function showLoading() {
		$('#loading-gif').show();
	}


	function hideLoading() {
		$('#loading-gif').hide();
	}

	$('#wizard1').steps({
		headerTag: 'h3',
		bodyTag: 'section',
		autoFocus: true,
		titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>'
	});

	$('#wizard2').steps({
		headerTag: 'h3',
		bodyTag: 'section',
		autoFocus: true,
		titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
		onStepChanging: function (event, currentIndex, newIndex) {
			showLoading();
			if (currentIndex < newIndex) {
				if (currentIndex === 0) {
					var fname = $('#firstname').parsley();
					var lname = $('#lastname').parsley();
					if (fname.isValid() && lname.isValid()) {
						hideLoading();
						return true;
					} else {
						fname.validate();
						lname.validate();
						hideLoading();
					}
				}
				if (currentIndex === 1) {
					var email = $('#email').parsley();
					if (email.isValid()) {
						hideLoading();
						return true;
					} else {
						email.validate();
						hideLoading();
					}
				}
			} else {
				hideLoading();
				return true;
			}
		}
	});

	$('#wizard3').steps({
		headerTag: 'h3',
		bodyTag: 'section',
		autoFocus: true,
		stepsOrientation: 1,
		titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',
		onStepChanging: function (event, currentIndex, newIndex) {
			showLoading();

			if (currentIndex < newIndex) {
				let isValid = true;

				if (currentIndex === 0) isValid = validateStepOne();
				if (currentIndex === 1) isValid = validateStepTwo();
				if (currentIndex === 2) isValid = validateStepThree();

				if (!isValid) {
					setTimeout(() => {
						hideLoading();
					}, 300);
					return false;
				}
			}
			setTimeout(() => {
				hideLoading();
			}, 300);

			return true;
		},
		onFinishing: function () {
			return validateStepThree();
		},
		onFinished: function () {
			Swal.fire({
				title: 'Are you sure?',
				text: 'Do you want to save this course?',
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Yes, save it!',
				cancelButtonText: 'No, cancel!'
			}).then((result) => {
				if (result.isConfirmed) {
					showLoading();
					const courseData = {
						title: $('#course_title').val(),
						description: $('#course_description').val(),
						language: $('#language').val(),
						difficulty: $('#course_difficulty').val(),
						tags: $('#course_tags').val().split(','),
						thumbnail: $('#course_thumbnail')[0].files[0],
						category_id: $('#category_id').val(),
						instructor_id: $('#instructor_id').val(),
						pricing_category: $('#pricing_category').val(),
						is_published: $('#is_published').is(':checked'),
					};

					let formData = new FormData();

					formData.append('title', courseData.title);
					formData.append('description', courseData.description);
					formData.append('language', courseData.language);
					formData.append('difficulty', courseData.difficulty);
					formData.append('tags', JSON.stringify(courseData.tags));
					formData.append('thumbnail', courseData.thumbnail);
					formData.append('category_id', courseData.category_id);
					formData.append('pricing_category', courseData.pricing_category);
					formData.append('instructor_id', courseData.instructor_id);
					formData.append('is_published', $('#is_published').is(':checked'));

					$.ajax({
						url: '/courses/store-course',
						type: 'POST',
						data: formData,
						processData: false,
						contentType: false,
						success: function (data) {
							hideLoading();

							if (data.status) {
								Swal.fire({
									title: 'Success',
									text: data.message,
									icon: 'success'
								}).then((result) => {
									location.reload();
								});
							}
						},
						error: function (data) {
							hideLoading();

							$('body').html(data.responseText);
						}
					});
				} else {
					Swal.fire('Cancelled', 'Course saving was cancelled.', 'error');
					hideLoading();
				}
			});
		}
	});

	// Step validation functions
	function validateStepOne() {
		$('#course_title, #instructor_id, #category_id, #language').removeClass('is-invalid');
		const course_title = $('#course_title').val().trim();
		const instructor_id = $('#instructor_id').val().trim();
		const category_id = $('#category_id').val().trim();
		const language = $('#language').val().trim();

		let errors = [];
		if (!course_title) {
			errors.push('• Course title is required');
			$('#course_title').addClass('is-invalid');
		}
		if (!instructor_id) {
			errors.push('• Instructor is required');
			$('#instructor_id').addClass('is-invalid');
		}
		if (!category_id) {
			errors.push('• Category is required');
			$('#category_id').addClass('is-invalid');
		}
		if (!language) {
			errors.push('• Language is required');
			$('#language').addClass('is-invalid');
		}

		if (errors.length > 0) {
			hideLoading();
			Swal.fire('Missing or Invalid Fields', errors.join('<br>'), 'error');
			return false;
		}

		return true;
	}

	function validateStepTwo() {
		$('#course_description, #course_difficulty, #course_tags').removeClass('is-invalid');

		const description = $('#course_description').val().trim();
		const difficulty = $('#course_difficulty').val().trim();
		const tags = $('#course_tags').val().trim();

		let errors = [];
		if (!description) {
			errors.push('• Course Description is required');
			$('#course_description').addClass('is-invalid');
		}
		if (!difficulty) {
			errors.push('• Course Difficulty is required');
			$('#course_difficulty').addClass('is-invalid');
		}
		if (!tags) {
			errors.push('• Course Tags is required');
			$('#course_tags').addClass('is-invalid');
		}

		if (errors.length > 0) {
			hideLoading();
			Swal.fire('Missing or Invalid Fields', errors.join('<br>'), 'error');
			return false;
		}

		return true;
	}

	function validateStepThree() {
		$('#course_thumbnail, #is_published').removeClass('is-invalid');

		const course_thumbnail = $('#course_thumbnail').val().trim();
		const is_published = $('#is_published').is(':checked');

		let errors = [];
		if (!course_thumbnail) {
			errors.push('• Attaching course thumbnail is required');
			$('#course_thumbnail').addClass('is-invalid');
		}
		if (!is_published) {
			errors.push('• Checking to publish course is required');
			$('#is_published').addClass('is-invalid');
		}

		if (errors.length > 0) {
			hideLoading();
			Swal.fire('Missing or Invalid Fields', errors.join('<br>'), 'error');
			return false;
		}

		return true;
	}

});
