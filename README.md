# cs4014-project
Group repo for CS4014/Web App Development project.

Overview:

interactive web platform to facilitate the proofreading of student theses,
dissertations, assignments, research papers alike among students and staff. The
main idea behind the website is to allow students to publish their academic documents
and get them proofread/reviewed by peers. Members will create profiles and based
on their actions will gain a reputation score. A reputation of more than 40 results
in the user being promoted to admin.

# The website will have the following pages/fuctionality

## Login page
  -login (ID,
          password)

  -sign up (firstname,
            lastname,
            student/staff ID,
            email,
            subject/field of study,
            password,
            confrirm password)

## task creation page
  -where members can create tasks
  -tasks creation involves:
      -Task title
      -Task type (MSc thesis, BSc dissertation, project report etc.)
      -task description
      -tags (max 4)
      -num pages
      -num words
      -file format
      -sample of document
      -deadlines:
          -task claiming deadline
          -task completion deadline


## Task list page
    -The user can browse tasks on this page.
 
## Task details page

  -When the user clicks on a task the come to this page and view the details of
   the task. (including a sample of the document to be reviewed / proof read).
  -User can claim a task here.

## Claimed task page

  -lists claimed tasks
  -ability to mark task as complete
  -ability to request full file from owner
  -ability to cancel tasks (this leads to -15 reputation.)
  -Submissions may be marked as failed after the date is expired

## My tasks page
  -list tasks created and show state (pending claim,
                                      unclaimed,
                                      claimed,
                                      cancelled (by the claimant)
                                      or completed)
  -This could also act as a profile page with a users picture/icon,
   their details and the ability for them to alter or delete their profiles.
   Admins could ban members here too.



## Flagged task page (to be seen by moderators only)
  -flagged tasks can be viewed by moderators here and taken down if moderators
  see fit.

## Search / results page    

## Extra features
  -Edit profile
  -delete profile
  -Search tasks
  -FAQ/help page
  (I believe we should implement all of the above and we can discuss whether or not we should implement the further features below)
  -login security / email verification
  -Also viewed features
  -Ability for user to subscribe to number of tags
  -automatic tag completion
  -login security / email verification
  -recaptcha forms for spamming

## Note on setting up permissions for file uploaded
  There may be permission errors trying to uplioad files. To fix this I carried out these commands:

  ```
  chown -R user:www-data yourprojectfoldername

  chmod 775 yourprojectfoldername
  ```

  On the files folder within in the project.
