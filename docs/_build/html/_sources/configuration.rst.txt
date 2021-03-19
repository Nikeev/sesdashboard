.. index:: Installation

Configuration
=============

1.a. New AWS SES Console v2 (preferable)
----------------------------------------

* If none created yet, create a new Configuration Set. Log in into Amazon Simple Email Service console.

* Go to Configuration sets menu item under Configuration section and click Create set.

.. image:: /images/configuration-sets.png

* Fill Configuration set name and create set.

.. image:: /images/create-configuration-set.png

* At Event configuration page click Event destinations and Add destination.

.. image:: /images/event-destinations.png

* Chose Event types you wish to track and click Next. (Note: Not all events supported yet.)

.. image:: /images/select-event-types.png

* Under Destination options choose Amazon SNS, fill destination Name. Next create new SNS topic or use existing.

.. image:: /images/specify-destination.png

* Review and Add destination.

* Under Verified identities choose identity you wish to track. Go to Configuration step tab and click Edit.

.. image:: /images/default-configuration-set.png

* Check Assign a default configuration set, select Default configuration set you recently created and save changes.

.. image:: /images/apply-default-configuration-set.png

* Go to :ref:`2. AWS SNS Configuration step` paragraph below.

1.b. AWS SES Console v1
-----------------------

* Go to Amazon Simple Email Service (SES) console. There are 2 ways to configure events publishing. First is to create new Configuration Set. It allows you to track opens and clicks but requires you to pass specific email header X-SES-CONFIGURATION-SET. More about headers configuration: https://docs.aws.amazon.com/ses/latest/DeveloperGuide/event-publishing-send-email.html Second option doesn't require any changes in your existing app, but cannot track clicks and opens.
* First option: Select Configuration Sets menu. Click Create Configuration Set or edit your existing set. Add new SNS Destination, select events to track and create SNS topic.
* Second option: Under Identity Management select Domain or Email address and open Notifications tab. Click Edit Configuration and create or select SNS Topic for events you wish to track. Enable Include original headers.

.. _2. AWS SNS Configuration step:

2. AWS SNS Configuration step
-----------------------------

* Next, navigate to Amazon Simple Notification Service (SNS).

* Click Topics section and select topic you created before.

.. image:: /images/sns-topics.png

* Click Create subscription

.. image:: /images/sns-subscriptions.png

* Add new subscription with HTTP (or HTTPS protocol if configured) and paste WebHook url from ``/project/1/edit`` SesDashboard project page. Check Enable raw message delivery.

.. image:: /images/create-subscription.png

.. image:: /images/webhook.png