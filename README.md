# messenger

Full Version Messenger - Frontend + Backend

[login.php]

- logo (o)
- id/pw input (o)
- 'remember id' checkbox (o)
  after login submit, the checkbox state is sent as POST data (o), and if the box is checked, the cookie that stores user id is sent back (o), else the cookie expires (o). so when the login page first loads, it should check if there's any cookie stored. (o)
- 'sign up' link (o)
  simply a link to 'signup.php'.(o)
- login button (o)
  sends form data to login.php (itself) (o) and if the userid & password matches, it redirects to 'friends.php'.(o) if not, stay at 'login.php'. (-)

[friends.php]

- search icon --> click --> search modal pops up
- add friend icon --> click --> add friend modal
- logout button --> logout.php
- my profile at the top
- followed by friends' profiles
- navbar at the bottom
