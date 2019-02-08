# newrelic-php-api-example
An example of how to use most of the php agent API calls for new relic's agent

You'll need to install the NR PHP agent:

https://docs.newrelic.com/docs/agents/php-agent/getting-started/new-relic-php

...and have an account with NR which will give you a license key to configure the daemon. You can use a 15 days license though.

These scripts are inspired in this other repository:

https://github.com/fool/newrelic-php-api-example

A second script was added to simulate a second trace called bigfoot.

A robot was added to push information every second. To execute you can do:

```bash
nohup robot.sh &
```