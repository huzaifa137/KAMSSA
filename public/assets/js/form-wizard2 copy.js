$(function () {
	'use strict';

	// Wizard 1 & 2 (unchanged)
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
			if (currentIndex < newIndex) {
				if (currentIndex === 0) {
					var fname = $('#firstname').parsley();
					var lname = $('#lastname').parsley();
					if (fname.isValid() && lname.isValid()) {
						return true;
					} else {
						fname.validate();
						lname.validate();
					}
				}
				if (currentIndex === 1) {
					var email = $('#email').parsley();
					if (email.isValid()) {
						return true;
					} else {
						email.validate();
					}
				}
			} else {
				return true;
			}
		}
	});

	// Wizard 3 with all 3-step validation and onFinish
	$('#wizard3').steps({
		headerTag: 'h3',
		bodyTag: 'section',
		autoFocus: true,
		stepsOrientation: 1,
		titleTemplate: '<span class="number">#index#<\/span> <span class="title">#title#<\/span>',

		onStepChanging: function (event, currentIndex, newIndex) {
			if (currentIndex < newIndex) {
				if (currentIndex === 0) return validateStepOne();
				if (currentIndex === 1) return validateStepTwo();
				if (currentIndex === 2) return validateStepThree();
			}
			return true; // allow going back
		},

		onFinishing: function () {
			return validateStepThree(); // validate final step before finishing
		},

		onFinished: function () {
			Swal.fire('Success!', 'Course has been successfully submitted.', 'success');
			// You can also trigger actual form submission here
			// $('#your-form-id').submit();
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
			Swal.fire('Missing or Invalid Fields', errors.join('<br>'), 'error');
			return false;
		}

		return true;
	}
});
