<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Job Application Portal'; ?></title>
    <style>
        * {
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }
        body {
            background-color: #f1f5f9;
            margin: 0;
            padding: 40px 15px;
            color: #1e293b;
        }
        .container {
            max-width: 680px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 12px;
            padding: 35px 40px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -2px rgba(0, 0, 0, 0.05);
        }
        h2 {
            text-align: center;
            margin: 0 0 25px 0;
            color: #0f172a;
            font-size: 24px;
            font-weight: 700;
        }
        .progress-steps {
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            margin-bottom: 35px;
        }
        .progress-steps::before {
            content: '';
            position: absolute;
            top: 18px;
            left: 40px;
            right: 40px;
            height: 2px;
            background: #e2e8f0;
            z-index: 1;
        }
        .step-indicator {
            position: relative;
            z-index: 2;
            text-align: center;
            background: #ffffff;
            padding: 0 8px;
        }
        .circle {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: #ffffff;
            border: 2px solid #cbd5e1;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            font-size: 14px;
            margin: 0 auto 6px auto;
        }
        .step-label {
            font-size: 12px;
            color: #64748b;
            font-weight: 500;
        }
        .step-indicator.active .circle {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }
        .step-indicator.active .step-label {
            color: #2563eb;
            font-weight: 700;
        }
        .step-indicator.completed .circle {
            background: #16a34a;
            border-color: #16a34a;
            color: #ffffff;
        }
        .alert-success {
            background: #dcfce7;
            color: #166534;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #bbf7d0;
            font-size: 14px;
            font-weight: 500;
        }
        .alert-danger {
            background: #fee2e2;
            color: #991b1b;
            padding: 14px 18px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #fecaca;
            font-size: 14px;
        }
        .alert-danger p {
            margin: 4px 0;
        }
        .form-step {
            display: none;
        }
        .form-step.active {
            display: block;
        }
        .form-group {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 6px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
        }
        .required-star {
            color: #ef4444;
        }
        .form-control {
            width: 100%;
            padding: 10px 14px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: border-color 0.15s ease;
        }
        .form-control:focus {
            border-color: #2563eb;
        }
        .radio-group {
            display: flex;
            gap: 20px;
            margin-top: 6px;
        }
        .inline-label {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 14px;
            font-weight: normal;
            cursor: pointer;
            margin-bottom: 0;
        }
        .checkbox-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
            margin-top: 8px;
        }
        .btn-group {
            display: flex;
            justify-content: space-between;
            margin-top: 30px;
            gap: 12px;
        }
        .btn {
            padding: 10px 22px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            border: none;
            transition: background 0.15s ease;
        }
        .btn-prev {
            background: #94a3b8;
            color: #ffffff;
        }
        .btn-prev:hover {
            background: #64748b;
        }
        .btn-next, .btn-submit {
            background: #2563eb;
            color: #ffffff;
            margin-left: auto;
        }
        .btn-next:hover, .btn-submit:hover {
            background: #1d4ed8;
        }
        #char_counter {
            display: block;
            text-align: right;
            color: #64748b;
            margin-top: 4px;
            font-size: 12px;
        }
        #file_info {
            display: none;
            margin-top: 8px;
            font-size: 13px;
            color: #0f766e;
            background: #f0fdf4;
            padding: 6px 12px;
            border-radius: 6px;
            border: 1px solid #bbf7d0;
        }
        @media (max-width: 640px) {
            .checkbox-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .container {
                padding: 24px 18px;
            }
        }
        /* high contrast accessible focus states */
input:focus-visible,
select:focus-visible,
textarea:focus-visible,
button:focus-visible {
    outline: 3px solid #1d4ed8 !important;
    outline-offset: 2px !important;
    border-color: #1d4ed8 !important;
}

.form-control:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
}

.inline-label:focus-within {
    outline: 2px solid #2563eb;
    outline-offset: 2px;
    border-radius: 4px;
}
    </style>
</head>
<body>

<div class="container">
    <h2>Job Application Portal</h2>

    <!-- Flash message on success -->
    <?php if ($this->session->flashdata('success')): ?>
        <div class="alert-success">
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php endif; ?>

    <!-- Server-side validation errors -->
    <?php if (validation_errors() || !empty($upload_error) || !empty($server_error)): ?>
        <div class="alert-danger">
            <?php echo validation_errors(); ?>
            <?php if (!empty($upload_error)): ?>
                <p><?php echo $upload_error; ?></p>
            <?php endif; ?>
            <?php if (!empty($server_error)): ?>
                <p><?php echo $server_error; ?></p>
            <?php endif; ?>
        </div>
    <?php endif; ?>

    <!-- Step Progress Indicators -->
    <div class="progress-steps">
        <div class="step-indicator active" id="indicator-1">
            <div class="circle">1</div>
            <div class="step-label">Basic Info</div>
        </div>
        <div class="step-indicator" id="indicator-2">
            <div class="circle">2</div>
            <div class="step-label">Academic Info</div>
        </div>
        <div class="step-indicator" id="indicator-3">
            <div class="circle">3</div>
            <div class="step-label">Experience & Resume</div>
        </div>
    </div>

    <!-- Application Form -->
    <form method="POST" action="<?php echo base_url('index.php/apply'); ?>" enctype="multipart/form-data" id="jobAppForm">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">

        <!-- Step 1: Basic Information -->
<div class="form-step active" id="step-1">
    <div class="form-group">
        <label for="full_name">Full Name <span class="required-star">*</span></label>
        <input type="text" name="full_name" id="full_name" class="form-control" value="<?php echo set_value('full_name'); ?>" placeholder="Enter your full name">
    </div>

    <div class="form-group">
        <label for="email">Email Address <span class="required-star">*</span></label>
        <input type="email" name="email" id="email" class="form-control" value="<?php echo set_value('email'); ?>" placeholder="name@example.com">
    </div>

    <div class="form-group">
        <label for="mobile_number">Mobile Number <span class="required-star">*</span></label>
        <input type="text" name="mobile_number" id="mobile_number" class="form-control" maxlength="10" value="<?php echo set_value('mobile_number'); ?>" placeholder="10-digit mobile number">
    </div>

    <div class="form-group">
        <label for="date_of_birth">Date of Birth <span class="required-star">*</span></label>
        <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" value="<?php echo set_value('date_of_birth'); ?>">
    </div>

    <div class="form-group">
        <label id="gender_group_label">Gender <span class="required-star">*</span></label>
        <div class="radio-group" role="radiogroup" aria-labelledby="gender_group_label">
            <label class="inline-label" for="gender_male">
                <input type="radio" name="gender" id="gender_male" value="Male" <?php echo set_radio('gender', 'Male'); ?>> Male
            </label>
            <label class="inline-label" for="gender_female">
                <input type="radio" name="gender" id="gender_female" value="Female" <?php echo set_radio('gender', 'Female'); ?>> Female
            </label>
            <label class="inline-label" for="gender_other">
                <input type="radio" name="gender" id="gender_other" value="Other" <?php echo set_radio('gender', 'Other'); ?>> Other
            </label>
        </div>
    </div>

    <div class="form-group">
        <label for="address">Address <span class="required-star">*</span></label>
        <textarea name="address" id="address" class="form-control" rows="3" placeholder="Enter complete residential address"><?php echo set_value('address'); ?></textarea>
    </div>

    <div class="form-group">
        <label for="nationality">Nationality <span class="required-star">*</span></label>
        <select name="nationality" id="nationality" class="form-control">
            <option value="">-- Select Nationality --</option>
            <option value="Indian" <?php echo set_select('nationality', 'Indian', TRUE); ?>>Indian</option>
            <option value="Other" <?php echo set_select('nationality', 'Other'); ?>>Other</option>
        </select>
    </div>

    <div class="form-group">
        <label id="relocate_group_label">Willingness to Relocate <span class="required-star">*</span></label>
        <div class="radio-group" role="radiogroup" aria-labelledby="relocate_group_label">
            <label class="inline-label" for="relocate_yes">
                <input type="radio" name="willing_to_relocate" id="relocate_yes" value="Yes" <?php echo set_radio('willing_to_relocate', 'Yes'); ?>> Yes
            </label>
            <label class="inline-label" for="relocate_no">
                <input type="radio" name="willing_to_relocate" id="relocate_no" value="No" <?php echo set_radio('willing_to_relocate', 'No'); ?>> No
            </label>
        </div>
    </div>

    <div class="btn-group">
        <button type="button" class="btn btn-next" onclick="validateAndNext(1)">Next Step &rarr;</button>
    </div>
</div>
<!-- Step 2: Academic Information -->
        <div class="form-step" id="step-2">
            <div class="form-group">
                <label for="highest_qualification">Highest Qualification <span class="required-star">*</span></label>
                <select name="highest_qualification" id="highest_qualification" class="form-control">
                    <option value="">-- Select Qualification --</option>
                    <option value="Bachelor's Degree" <?php echo set_select('highest_qualification', "Bachelor's Degree"); ?>>Bachelor's Degree</option>
                    <option value="Master's Degree" <?php echo set_select('highest_qualification', "Master's Degree"); ?>>Master's Degree</option>
                    <option value="Diploma" <?php echo set_select('highest_qualification', 'Diploma'); ?>>Diploma</option>
                    <option value="Doctorate" <?php echo set_select('highest_qualification', 'Doctorate'); ?>>Doctorate</option>
                </select>
            </div>

            <div class="form-group">
                <label for="institution_name">Institution / University Name <span class="required-star">*</span></label>
                <input type="text" name="institution_name" id="institution_name" class="form-control" value="<?php echo set_value('institution_name'); ?>" placeholder="Enter college or university name">
            </div>

            <div class="form-group">
                <label for="graduation_year">Year of Graduation <span class="required-star">*</span></label>
                <input type="text" name="graduation_year" id="graduation_year" class="form-control" maxlength="4" value="<?php echo set_value('graduation_year'); ?>" placeholder="e.g. 2026">
            </div>

            <div class="form-group">
                <label for="cgpa_percentage">CGPA / Percentage <span class="required-star">*</span></label>
                <input type="text" name="cgpa_percentage" id="cgpa_percentage" class="form-control" value="<?php echo set_value('cgpa_percentage'); ?>" placeholder="e.g. 8.5 or 85%">
            </div>

            <div class="form-group">
                <label id="tech_skills_group_label">Technical Skills <span class="required-star">*</span></label>
                <div class="checkbox-grid" role="group" aria-labelledby="tech_skills_group_label">
                    <?php 
                        $skill_options = array('PHP', 'MySQL', 'Python', 'JavaScript', 'HTML5 & CSS3', 'React', 'Node.js', 'SQL', 'Git / GitHub', 'Java', 'Tailwind CSS', 'Flask');
                        foreach ($skill_options as $index => $skill):
                            $skill_id = 'skill_' . preg_replace('/[^a-zA-Z0-9]/', '', strtolower($skill));
                    ?>
                        <label class="inline-label" for="<?php echo $skill_id; ?>">
                            <input type="checkbox" name="technical_skills[]" id="<?php echo $skill_id; ?>" value="<?php echo $skill; ?>" <?php echo set_checkbox('technical_skills[]', $skill); ?>> <?php echo $skill; ?>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="form-group">
                <label for="other_skills">Other / Additional Skills (comma separated):</label>
                <input type="text" name="other_skills" id="other_skills" class="form-control" value="<?php echo set_value('other_skills'); ?>" placeholder="e.g. Next.js, Power BI, MongoDB, ChromaDB">
            </div>

            <div class="form-group">
                <label for="certifications">Certifications (Optional)</label>
                <input type="text" name="certifications" id="certifications" class="form-control" value="<?php echo set_value('certifications'); ?>" placeholder="e.g. AWS Certified, NPTEL Python">
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-prev" onclick="goToStep(1)">&larr; Previous</button>
                <button type="button" class="btn btn-next" onclick="validateAndNext(2)">Next Step &rarr;</button>
            </div>
        </div>

        <!-- Step 3: Experience & Resume Upload -->
        <div class="form-step" id="step-3">
            <div class="form-group">
                <label for="total_experience">Total Work Experience <span class="required-star">*</span></label>
                <select name="total_experience" id="total_experience" class="form-control">
                    <option value="">-- Select Experience --</option>
                    <option value="Fresher" <?php echo set_select('total_experience', 'Fresher'); ?>>Fresher (0 years)</option>
                    <option value="1-2 Years" <?php echo set_select('total_experience', '1-2 Years'); ?>>1-2 Years</option>
                    <option value="3-5 Years" <?php echo set_select('total_experience', '3-5 Years'); ?>>3-5 Years</option>
                    <option value="5+ Years" <?php echo set_select('total_experience', '5+ Years'); ?>>5+ Years</option>
                </select>
            </div>

            <div class="form-group">
                <label id="status_group_label">Current Employment Status <span class="required-star">*</span></label>
                <div class="radio-group" role="radiogroup" aria-labelledby="status_group_label">
                    <label class="inline-label" for="status_employed">
                        <input type="radio" name="employment_status" id="status_employed" value="Employed" <?php echo set_radio('employment_status', 'Employed'); ?>> Employed
                    </label>
                    <label class="inline-label" for="status_unemployed">
                        <input type="radio" name="employment_status" id="status_unemployed" value="Unemployed" <?php echo set_radio('employment_status', 'Unemployed'); ?>> Unemployed
                    </label>
                    <label class="inline-label" for="status_notice">
                        <input type="radio" name="employment_status" id="status_notice" value="Notice Period" <?php echo set_radio('employment_status', 'Notice Period'); ?>> Notice Period
                    </label>
                    <label class="inline-label" for="status_student">
                        <input type="radio" name="employment_status" id="status_student" value="Student/Fresher" <?php echo set_radio('employment_status', 'Student/Fresher'); ?>> Student/Fresher
                    </label>
                </div>
            </div>

            <!-- Experience details block toggled for Freshers -->
            <div id="experience_details_block">
                <div class="form-group">
                    <label for="previous_organization">Previous / Current Organization</label>
                    <input type="text" name="previous_organization" id="previous_organization" class="form-control" value="<?php echo set_value('previous_organization'); ?>" placeholder="Enter company name">
                </div>

                <div class="form-group">
                    <label for="job_title">Job Title</label>
                    <input type="text" name="job_title" id="job_title" class="form-control" value="<?php echo set_value('job_title'); ?>" placeholder="e.g. Frontend Developer Intern">
                </div>
            </div>

            <div class="form-group">
                <label for="skills_summary">Skills Summary <span class="required-star">*</span></label>
                <textarea name="skills_summary" id="skills_summary" maxlength="300" class="form-control" rows="3" placeholder="Briefly highlight your core skills and project experience"><?php echo set_value('skills_summary'); ?></textarea>
                <small id="char_counter">300 characters remaining</small>
            </div>

            <div class="form-group">
                <label for="resume">Upload Resume <span class="required-star">*</span></label>
                <input type="file" name="resume" id="resume" class="form-control" accept=".pdf,.doc,.docx">
                <div id="file_info"></div>
            </div>

            <div class="form-group" style="margin-top: 25px;">
                <label class="inline-label" for="declaration_acceptance" style="font-weight: 500;">
                    <input type="checkbox" name="declaration_acceptance" id="declaration_acceptance" value="1" <?php echo set_checkbox('declaration_acceptance', '1'); ?>>
                    I hereby declare that the information provided above is true and accurate to the best of my knowledge. <span class="required-star">*</span>
                </label>
            </div>
            <div class="form-group" style="margin-top: 15px; margin-bottom: 20px;">
    <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
    <?php if (isset($captcha_error) && !empty($captcha_error)): ?>
        <span style="color: #dc2626; font-size: 13px; font-weight: 500; display: block; margin-top: 6px;">
            <?php echo $captcha_error; ?>
        </span>
    <?php endif; ?>
</div>

            <div class="btn-group">
                <button type="button" class="btn btn-prev" onclick="goToStep(2)">&larr; Previous</button>
                <button type="submit" class="btn btn-submit">Submit Application</button>
            </div>
        </div>
    </form>
</div>
<script>
function goToStep(step) {
    document.querySelectorAll('.form-step').forEach(function(el) {
        el.classList.remove('active');
    });

    var targetStep = document.getElementById('step-' + step);
    if (targetStep) {
        targetStep.classList.add('active');
    }

    for (var i = 1; i <= 3; i++) {
        var ind = document.getElementById('indicator-' + i);
        if (!ind) continue;
        ind.classList.remove('active');
        if (i < step) {
            ind.classList.add('completed');
        } else if (i === step) {
            ind.classList.add('active');
            ind.classList.remove('completed');
        } else {
            ind.classList.remove('completed');
        }
    }
    window.scrollTo({ top: 0, behavior: 'smooth' });
}

function validateAndNext(currentStep) {
    if (currentStep === 1) {
        var name = document.getElementById('full_name') ? document.getElementById('full_name').value.trim() : '';
        var email = document.getElementById('email') ? document.getElementById('email').value.trim() : '';
        var mobile = document.getElementById('mobile_number') ? document.getElementById('mobile_number').value.trim() : '';
        var dob = document.getElementById('date_of_birth') ? document.getElementById('date_of_birth').value : '';
        var gender = document.querySelector('input[name="gender"]:checked');
        var address = document.getElementById('address') ? document.getElementById('address').value.trim() : '';
        var nationality = document.getElementById('nationality') ? document.getElementById('nationality').value : '';
        var relocate = document.querySelector('input[name="willing_to_relocate"]:checked');

        if (!name || name.length < 3) {
            alert('Please enter your full name (at least 3 characters).');
            return;
        }
        if (!email || !email.includes('@')) {
            alert('Please enter a valid email address.');
            return;
        }
        if (!mobile || !/^\d{10}$/.test(mobile)) {
            alert('Please enter a valid 10-digit mobile number.');
            return;
        }
        if (!dob) {
            alert('Please select your date of birth.');
            return;
        }
        if (!gender) {
            alert('Please select your gender.');
            return;
        }
        if (!address) {
            alert('Please enter your residential address.');
            return;
        }
        if (!nationality) {
            alert('Please select your nationality.');
            return;
        }
        if (!relocate) {
            alert('Please specify your willingness to relocate.');
            return;
        }

        goToStep(2);
    } 
    else if (currentStep === 2) {
        var qual = document.getElementById('highest_qualification') ? document.getElementById('highest_qualification').value : '';
        var inst = document.getElementById('institution_name') ? document.getElementById('institution_name').value.trim() : '';
        var grad = document.getElementById('graduation_year') ? document.getElementById('graduation_year').value.trim() : '';
        var cgpa = document.getElementById('cgpa_percentage') ? document.getElementById('cgpa_percentage').value.trim() : '';

        var checkedSkills = document.querySelectorAll('input[name="technical_skills[]"]:checked');
        var customSkill = document.getElementById('other_skills');
        var customVal = customSkill ? customSkill.value.trim() : '';

        if (!qual) {
            alert('Please select your highest qualification.');
            return;
        }
        if (!inst) {
            alert('Please enter your institution or university name.');
            return;
        }
        if (!grad || !/^\d{4}$/.test(grad)) {
            alert('Please enter a valid 4-digit graduation year.');
            return;
        }
        if (!cgpa) {
            alert('Please enter your CGPA or percentage.');
            return;
        }
        if (checkedSkills.length === 0 && customVal === '') {
            alert('Please select at least one technical skill or enter other skills.');
            return;
        }

        goToStep(3);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    // Jump straight to error step if server validation fails on submit
    var stepToOpen = <?php echo isset($open_step) ? (int)$open_step : 1; ?>;
    if (stepToOpen > 1) {
        goToStep(stepToOpen);
    }

    // 1. Show/hide experience details for freshers
    var expSelect = document.getElementById('total_experience');
    var expBlock = document.getElementById('experience_details_block');

    function toggleExp() {
        if (!expSelect || !expBlock) return;
        if (expSelect.value === 'Fresher') {
            expBlock.style.display = 'none';
        } else {
            expBlock.style.display = 'block';
        }
    }

    if (expSelect) {
        expSelect.addEventListener('change', toggleExp);
        toggleExp();
    }

    // 2. Character counter for skills summary
    var summaryInput = document.getElementById('skills_summary');
    var counterText = document.getElementById('char_counter');

    if (summaryInput && counterText) {
        summaryInput.addEventListener('input', function () {
            var remaining = 300 - this.value.length;
            counterText.textContent = remaining + ' characters remaining';
        });
    }

    // 3. Resume file details preview
    var fileInput = document.getElementById('resume');
    var fileInfo = document.getElementById('file_info');

    if (fileInput && fileInfo) {
        fileInput.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                var file = this.files[0];
                var sizeKb = (file.size / 1024).toFixed(1);
                fileInfo.style.display = 'block';
                fileInfo.textContent = 'Selected: ' + file.name + ' (' + sizeKb + ' KB)';
            } else {
                fileInfo.style.display = 'none';
            }
        });
    }

    // 4. Client-side check on step 3 submit
    var formEl = document.getElementById('jobAppForm');
    if (formEl) {
        formEl.addEventListener('submit', function (e) {
            var exp = document.getElementById('total_experience') ? document.getElementById('total_experience').value : '';
            var status = document.querySelector('input[name="employment_status"]:checked');
            var summary = document.getElementById('skills_summary') ? document.getElementById('skills_summary').value.trim() : '';
            var resumeInput = document.getElementById('resume');
            var declaration = document.querySelector('input[name="declaration_acceptance"]:checked');

            if (!exp) {
                alert('Please select your total work experience.');
                e.preventDefault();
                goToStep(3);
                return;
            }
            if (!status) {
                alert('Please select your current employment status.');
                e.preventDefault();
                goToStep(3);
                return;
            }
            if (!summary) {
                alert('Please fill out the skills summary field.');
                e.preventDefault();
                goToStep(3);
                document.getElementById('skills_summary').focus();
                return;
            }
            if (!resumeInput || !resumeInput.files || resumeInput.files.length === 0) {
                alert('Please upload your resume file (PDF, DOC, DOCX).');
                e.preventDefault();
                goToStep(3);
                return;
            }
            if (!declaration) {
                alert('Please check the declaration agreement before submitting.');
                e.preventDefault();
                goToStep(3);
                return;
            }
        });
    }
});
</script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
</body>
</html>