# mailnotifier
Mail generates based on DB templates

1. In CMD type ``` "composer require samcb/mailnotifier" ```.

To publish Config, Migration files run

2. ``` php artisan vendor:publish --tag=notifymail-config ```
3. ``` php artisan vendor:publish --tag=notifymail-migrations ```

4. Run ``` "php artisan migrate" ```
	This will create a migration table based on your notifymail config. Table name can be changeable.

In Your Controller(Example code)

5. If you want to replaceable words in your template, words must be in curly pharses like ``` {{your-key-to-replace}} ```.

Syntax to generate replace content:

**``` $details = Notifymail::generate_mail('template_unique_id','content_replace_array','subject_replace_array'); ```**

**template_unique_id** - It's a unique key of your template table.
**content_replace_array** - It's a replace of your content field.
**subject_replace_array** - It's a replace of your subject field.

6. You can check which fields are be replaceable by following comment.

**``` $chk_field = Notifymail::check_dynamic_fields(your-template-unique-id); ```**

7. Replace array content must be the order of the ```$chk_field```. And also all replaceable words must have alternative values. For example, In ```$chk_field``` have 5 replaceable variable you have to pass 5 alternative or your dynamic value. Otherwise it hits some error.

**Example:**

``` $replace_array_content=array("nameoforg","usernameplain","urloflogin","usernamehere","newpassword","logoimg","phnnum","emailhere","faxno"); ```

``` $replace_array_subject=array("register"); ```

``` $details = Notifymail::generate_records('1',$replace_array_content,''); ```

If you don't have/ want to replace subject or content, Leave them blank as above.

8. Above function generates your replaced content. If you want to send mail, you have some additional requirements.

**Example:**

``` $details = Notifymail::generate_records('1',$replace_array_content,''); ```

``` $details['email'] = "mail-name@domain.com"; (Must be only one mail id) ```

``` $details['from_mail'] = "mail-name@domain.com"; (Must be only one mail id) ```

``` $details['cc_mail'] = "mail-name@domain.com"; (You can send multiple by comma seperated string) ```

``` $details['bcc_mail'] = ""; (You can send multiple by comma seperated string) ```

``` $details['attachment'] = ""; (Must be only one mail id) ```

**``` $sendmail=Notifymail::send_mail($details); ```**

9. If you don't want to add CC, BCC, Attachment., leave them blank. array key must be present to avoid errors.
