# A REST API based invitation system
The API behaves in the following way:
> One user aka the Sender can send an invitation to another user aka the Invited.
> The Sender can cancel a sent invitation.
> The Invited can either accept or decline an invitation.
> The Sender can see a list of all invitations they have sent.
> The Invited can see a list of all invitations they have received.

### Technical specification

  - Based on Symfony 3
  - Includes an admin section developed with the Sonata Admin Bundle
  - 100% JSON Endpoint responses
  - Includes functional tests written in PHPUnit (+dedicated database)

### The endpoints
    - GET /api/user/all => lists all existing users
    - GET /api/invitation/all => lists all existing invitations
    - POST /api/user/{sender_id_name}/invite/{invited_id_name} => creates an invitation
    - PUT /api/user/{sender_id_name}/cancel/{invitation_id} => cancels an invitation
    - PUT /api/user/{invited_id_name}/accept/{invitation_id} => accepts an invitation
    - PUT /api/user/{invited_id_name}/decline/{invitation_id} => declines an invitation
    - GET /api/invitation/sentBy/{sender_id_name} => lists all invitations sent by {sender_id_name}
    - GET /api/invitation/receivedBy/{invited_id_name} => lists all invitations received by {invited_id_name}

### Installation

Configure your local Apache server to host the app and use composer to install the project dependencies.

### Technologies used for development

| System | Name/Version |
| ------ | ------ |
| Vesion control | Git |
| OS | Ubuntu/16.04 |
| Server | Apache/2.4.18 |
| Database | MySQL/14.14 |
| Programming language | PHP/7.2.5 |
| Framework | Symfony/3.4 |
| Testing framework | PHPUnit/5.1.3 |


### Tests
To run the tests, just execute:
```sh
$ ./vendor/bin/simple-phpunit
```
### Developed by
Mohamed Elkarim