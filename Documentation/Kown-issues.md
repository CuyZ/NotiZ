# Kown issues

## SQL error: 'Field 'send_to_provided' doesn't have a default value'

If this error occurs, you need to go into the Install Tool.

Then, go in the `All configuration` menu and search for `setDBinit`.

In the `[SYS][setDBinit]` textarea, put `SET SESSION sql_mode=''` and save.
