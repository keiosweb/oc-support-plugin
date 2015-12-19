# Keios Support Plugin

Simple support ticket manager for OctoberCMS written in 2 days by [Jakub Zych](http://keios.eu) 

![backend-screen](https://i.keios.eu/screenshot-151219-183307.png)

## Features

- Frontend and Backend ticket creation
- Tickets management
- E-mail notifications

## Installation

Plugin requires Rainlab Translate plugin and either [Keios ProUser](https://lab.keios.eu/october_plugins/keios-prouser) or [Rainlab User](https://octobercms.com/plugin/rainlab-user) for user management.

    cd /path/to/your/octobercms/plugins
    mkdir keios
    cd keios
    git clone https://github.com/keiosweb/oc-support-plugin.git support
    cd support
    composer update
    cd ../../..
    php artisan plugin:refresh keios.support

## Configuration

Plugin includes four components - each of them should be put on a page accessible only to registered users. Default views use *Twitter Bootstrap* classes. 

#### Ticket Form

Ticket Form a ticket creation form. You should put it on a website with user access only.

#### Ticket List

This is a component that will display all tickets created by user. 

#### Ticket Attach

This component is responsible for frontend file upload requests processing. Put it on a clear page, without layout. 

#### Ticket Status

This component displays ticket, its current status, comments and files and allows to add comments and files. 

Component requires page with slug (eg /ticket/:hash). This slug, as well as page created for TicketAttach component, must then be entered into component properties. 

![ticket-status](https://i.keios.eu/screenshot-151219-182652.png)

#### Settings

Currently in Settings -> Support Settings there is only one field - *Full ticket page address*. You should enter there a fully qualified address of your ticket page (for example https://my.company.com/ticket-status/)


## Tickets Management

Plugin allows registered clients to create support tickets, attach files to them and add comments. Created ticket appears in the backend as **New**, unassigned ticket and can be assigned to backend user. 
 
 After assignation, ticket changes status to **Assigned** and can be further modified (by assigning different status, priority or adding comments).

## Commenting

Comments can be added by the creator of the ticket or by the backend user. Frontend is using *TinyMCE* for text editor, further protected from javascript injections by *HTMLPurifier*. Backend comments section is using october-included *Redactor* editor.

## Mailing

Plugin has a basic mailing possibilities, covered by **SupportMailer** class. Right now it mails the user after creating ticket and after ticket update.

## Statuses, Priorities and Categories

Plugins includes some generic statuses (like *New*, *Assigned*, *Pending* etc) and priorities (like *Low*, *Medium*, *High*) etc. **New** and **Assigned** are required statuses for proper plugin functioning. Categories are selectable by customer during ticket creation.

Additional statuses, priorities and categories can be added using **Categories**, **Ticket Statuses** and **Ticket Priorities** backend controllers.

Ticket list can be filtered by priorioty, status and category.

## Translations

Plugin includes lang files for English and Polish. Frontend content can be translated by overriding components partials in theme, as they include *RainLab Translate* twig filters. 

## TODO

There is still a lot to do, most important points are:

**High priority**

- Separation of supporters (eg basic permissions allow only to see tickets that are new or assigned to self)
- Adding files from backend and better backend file management
- Tickets account (assigning customer given number of ticket and rejecting those above quota)
- Ticket updates messages in comments section
- Mailing upgrade - different email templates for different update types, mailing full comments content etc

**Low priority**

- Preparation of default generic OctoberCMS theme
- Internal tickets (where ticket creator is backend user) (?)