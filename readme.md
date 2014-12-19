# WordPress Plugin »Send ›Admin‹ Home«

Most of the script kiddies »I-guess-your-password« attacks using `admin` or `administrator` as login.
This plugin guides them directly and safe home. Most of them using distributed attacks, so IP blocking isn't
an option.

## Under the hood
If those login names exists in your blog, they won't be redirected of course. The validator can be
filtered by `send_admin_home_validator`. Make sure to implement the `SendAdminHome\LoginValidatorInterface`.