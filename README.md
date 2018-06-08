# cs4014-project
Group repo for CS4014/Web App Development project.

# Overview:

Interactive web platform to facilitate the proofreading of student theses,
dissertations, assignments and research papers among students and staff. The
main idea behind the website is to allow students to publish their academic documents
and get them proofread/reviewed by peers. Members will create profiles and based
on their actions will gain a reputation score. A reputation of more than 40 results
in the user being promoted to admin.

# Technology

## Front end
* Bootstrap 4 for creating and styling components.
* Sass to create custom styles.
* Javascript to facilitate asynchronous requests.
* Grunt for javasctipt minification

## Back end
* MySQL relational database.
* Object oriented PHP handles requests, modifies databases.

# Functionality

## Login page
  * login (ID,
          password)

  * sign up (firstname,
            lastname,
            student/staff ID,
            email,
            subject/field of study,
            password,
            confrirm password)

## Task creation page
  * where members can create tasks
  * tasks creation involves:
      * Task title
      * Task type (MSc thesis, BSc dissertation, project report etc.)
      * task description
      * tags (max 4)
      * num pages
      * num words
      * file format
      * sample of document
      * deadlines:
          * task claiming deadline
          * task completion deadline


## Task list page
  * The user can browse tasks on this page.

## Task details page
  * When the user clicks on a task they will come to this page and view the details of
   the task.
  * User can claim a task here.

## Claimed task page
  * lists claimed tasks.
  * ability to mark task as complete.
  * ability to request full file from owner.
  * ability to cancel tasks (this leads to -15 reputation).
  * Submissions may be marked as failed after the date is expired.

## My tasks page
  * list tasks created and show state (pending claim,
                                      unclaimed,
                                      claimed,
                                      cancelled (by the claimant)
                                      or completed).
 * This could also act as a profile page with a users picture/icon,
   their details and the ability for them to alter or delete their profiles.
   Admins could ban members here too.



## Flagged task page (to be seen by moderators only)
  * flagged tasks can be viewed by moderators here and taken down if moderators
  see fit.

## Search / results page    

## Extra features
  * Edit profile.
  * delete profile.
  * Search tasks.
  * FAQ/help page.
  * login security / email verification.
  * Also viewed features.
  
  # Authors
  * Jamie Mac Manus
  * Rory Egan
