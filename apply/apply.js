$document.ready(function()
{
    $("#applyForm").validate(
    {
            rules:
            {
                    aboutYourself:
                    {
                            required: true
                    },
                    whyAttend:
                    {
                            required: true
                    },
                    otherLinks:
                    {
                            required: true
                    },
                    progExperience:
                    {
                            required: true
                    },
                    fullName:
                    {
                            required: true
                    },
                    phoneNumber:
                    {
                            required: true
                    },
                    emailAddress:
                    {
                            required: true,
                            email: true
                    },
                    howHeard:
                    {
                            required: true
                    }
            },

            messages:
            {
                    aboutYourself:  "Please tell us about yourself",
                    whyAttend:      "Please tell us why you'd like to attend",
                    otherLinks:     "Please provide additional information about yourself",
                    progExperience: "Please tell us about your programming experience",
                    fullName:       "Please enter your full name",
                    phoneNumber:    "Please enter your phone number",
                    emailAddress:   "Please enter your Email address",
                    birthday:       "Please enter your birthday",
                    howHeard:       "Please tell us how you heard about us"
            }
    });
});
