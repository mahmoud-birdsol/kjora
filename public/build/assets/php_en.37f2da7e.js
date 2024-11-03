const t={"auth.failed":"These credentials do not match our records.","auth.password":"The provided password is incorrect.","auth.throttle":"Too many login attempts. Please try again in :seconds seconds.","pagination.previous":"&laquo; Previous","pagination.next":"Next &raquo;","passwords.reset":"Your password has been reset!","passwords.sent":"We have emailed your password reset link!","passwords.throttled":"Please wait before retrying.","passwords.token":"This password reset token is invalid.","passwords.user":"We can't find a user with that email address.","validation.accepted":"The :attribute must be accepted.","validation.accepted_if":"The :attribute must be accepted when :other is :value.","validation.active_url":"The :attribute is not a valid URL.","validation.after":"The :attribute must be a date after :date.","validation.after_or_equal":"The :attribute must be a date after or equal to :date.","validation.alpha":"The :attribute must only contain letters.","validation.alpha_dash":"The :attribute must only contain letters, numbers, dashes and underscores.","validation.alpha_num":"The :attribute must only contain letters and numbers.","validation.array":"The :attribute must be an array.","validation.before":"The :attribute must be a date before :date.","validation.before_or_equal":"The :attribute must be a date before or equal to :date.","validation.between.array":"The :attribute must have between :min and :max items.","validation.between.file":"The :attribute must be between :min and :max kilobytes.","validation.between.numeric":"The :attribute must be between :min and :max.","validation.between.string":"The :attribute must be between :min and :max characters.","validation.boolean":"The :attribute field must be true or false.","validation.confirmed":"The :attribute confirmation does not match.","validation.current_password":"The password is incorrect.","validation.date":"The :attribute is not a valid date.","validation.date_equals":"The :attribute must be a date equal to :date.","validation.date_format":"The :attribute does not match the format :format.","validation.declined":"The :attribute must be declined.","validation.declined_if":"The :attribute must be declined when :other is :value.","validation.different":"The :attribute and :other must be different.","validation.digits":"The :attribute must be :digits digits.","validation.digits_between":"The :attribute must be between :min and :max digits.","validation.dimensions":"The :attribute has invalid image dimensions.","validation.distinct":"The :attribute field has a duplicate value.","validation.doesnt_end_with":"The :attribute may not end with one of the following: :values.","validation.doesnt_start_with":"The :attribute may not start with one of the following: :values.","validation.email":"The :attribute must be a valid email address.","validation.ends_with":"The :attribute must end with one of the following: :values.","validation.enum":"The selected :attribute is invalid.","validation.exists":"The selected :attribute is invalid.","validation.file":"The :attribute must be a file.","validation.filled":"The :attribute field must have a value.","validation.gt.array":"The :attribute must have more than :value items.","validation.gt.file":"The :attribute must be greater than :value kilobytes.","validation.gt.numeric":"The :attribute must be greater than :value.","validation.gt.string":"The :attribute must be greater than :value characters.","validation.gte.array":"The :attribute must have :value items or more.","validation.gte.file":"The :attribute must be greater than or equal to :value kilobytes.","validation.gte.numeric":"The :attribute must be greater than or equal to :value.","validation.gte.string":"The :attribute must be greater than or equal to :value characters.","validation.image":"The :attribute must be an image.","validation.in":"The selected :attribute is invalid.","validation.in_array":"The :attribute field does not exist in :other.","validation.integer":"The :attribute must be an integer.","validation.ip":"The :attribute must be a valid IP address.","validation.ipv4":"The :attribute must be a valid IPv4 address.","validation.ipv6":"The :attribute must be a valid IPv6 address.","validation.json":"The :attribute must be a valid JSON string.","validation.lowercase":"The :attribute must be lowercase.","validation.lt.array":"The :attribute must have less than :value items.","validation.lt.file":"The :attribute must be less than :value kilobytes.","validation.lt.numeric":"The :attribute must be less than :value.","validation.lt.string":"The :attribute must be less than :value characters.","validation.lte.array":"The :attribute must not have more than :value items.","validation.lte.file":"The :attribute must be less than or equal to :value kilobytes.","validation.lte.numeric":"The :attribute must be less than or equal to :value.","validation.lte.string":"The :attribute must be less than or equal to :value characters.","validation.mac_address":"The :attribute must be a valid MAC address.","validation.max.array":"The :attribute must not have more than :max items.","validation.max.file":"The :attribute must not be greater than :max kilobytes.","validation.max.numeric":"The :attribute must not be greater than :max.","validation.max.string":"The :attribute must not be greater than :max characters.","validation.max_digits":"The :attribute must not have more than :max digits.","validation.mimes":"The :attribute must be a file of type: :values.","validation.mimetypes":"The :attribute must be a file of type: :values.","validation.min.array":"The :attribute must have at least :min items.","validation.min.file":"The :attribute must be at least :min kilobytes.","validation.min.numeric":"The :attribute must be at least :min.","validation.min.string":"The :attribute must be at least :min characters.","validation.min_digits":"The :attribute must have at least :min digits.","validation.multiple_of":"The :attribute must be a multiple of :value.","validation.not_in":"The selected :attribute is invalid.","validation.not_regex":"The :attribute format is invalid.","validation.numeric":"The :attribute must be a number.","validation.password.letters":"The :attribute must contain at least one letter.","validation.password.mixed":"The :attribute must contain at least one uppercase and one lowercase letter.","validation.password.numbers":"The :attribute must contain at least one number.","validation.password.symbols":"The :attribute must contain at least one symbol.","validation.password.uncompromised":"The given :attribute has appeared in a data leak. Please choose a different :attribute.","validation.present":"The :attribute field must be present.","validation.prohibited":"The :attribute field is prohibited.","validation.prohibited_if":"The :attribute field is prohibited when :other is :value.","validation.prohibited_unless":"The :attribute field is prohibited unless :other is in :values.","validation.prohibits":"The :attribute field prohibits :other from being present.","validation.regex":"The :attribute format is invalid.","validation.required":"The :attribute field is required.","validation.required_array_keys":"The :attribute field must contain entries for: :values.","validation.required_if":"The :attribute field is required when :other is :value.","validation.required_if_accepted":"The :attribute field is required when :other is accepted.","validation.required_unless":"The :attribute field is required unless :other is in :values.","validation.required_with":"The :attribute field is required when :values is present.","validation.required_with_all":"The :attribute field is required when :values are present.","validation.required_without":"The :attribute field is required when :values is not present.","validation.required_without_all":"The :attribute field is required when none of :values are present.","validation.same":"The :attribute and :other must match.","validation.size.array":"The :attribute must contain :size items.","validation.size.file":"The :attribute must be :size kilobytes.","validation.size.numeric":"The :attribute must be :size.","validation.size.string":"The :attribute must be :size characters.","validation.starts_with":"The :attribute must start with one of the following: :values.","validation.string":"The :attribute must be a string.","validation.timezone":"The :attribute must be a valid timezone.","validation.unique":"The :attribute has already been taken.","validation.uploaded":"The :attribute failed to upload.","validation.uppercase":"The :attribute must be uppercase.","validation.url":"The :attribute must be a valid URL.","validation.uuid":"The :attribute must be a valid UUID.","validation.phone":"The :attribute field contains an invalid number.","validation.custom.attribute-name.rule-name":"custom-message"};export{t as default};
