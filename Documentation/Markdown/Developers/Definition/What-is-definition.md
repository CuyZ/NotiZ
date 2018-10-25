# What is the definition

NotiZ is based on a configuration object, called the “*definition*”. It allows 
administrators to manage how events and notifications will be processed during 
runtime.

If you want to register a new event or configure notifications, you will need to 
extend the definition. Definition values can be written inside files in your own 
extension. 

The most simple way to register a definition file is to add a piece of code in
the `ext_localconf.php` file of your extension; find more information in the 
chapter “[Add file definition](Add-file-definition.md)”.

If you need more complex logic, you can use a so-called “definition component 
service”; see chapter 
“[Advanced definition handling](Advanced-definition-handling.md)” for more 
information. 

---

[:books: Documentation index](../../README.md)
