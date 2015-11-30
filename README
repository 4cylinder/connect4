# CSC309 Assignment 3 (April 4, 2014)

-------------------------------------------------------------------------------
                                Instructions
-------------------------------------------------------------------------------
- IMPORTANT: Replace the .htaccess file in the connect4 folder with your own (to remove index.php from URLs)
- Replace application/config/database.php with your own
- From the main page, register an account (note the Captcha securimage)
- If you register successfully, you will be directed to the login page
- Enter your password and you will go to the lobby
- If there are other others online they will be shown in the lobby. Otherwise you can log out and check back later
- If there's another player online, click his name (shown in the lobby) to  invite him to a match. Or he can invite you (you will be prompted to accept)
- Play Connect 4 until the match is over (someone wins or there is a tie)
- A JS alert window pops up when the match is over.
- When a match ends, click "Back to game lobby" if you wish to play again
- Or click "log out" to end your session completely.
-------------------------------------------------------------------------------
                       Controllers that we modified
-------------------------------------------------------------------------------
- account.php: Added securimage captcha function and a callback validation
- arcade.php: Players show as online in the lobby if they quit a game mid-match
- board.php: Functions for handling gameplay using AJAX, JSON, and transactions
-------------------------------------------------------------------------------
                         Views that we modified
-------------------------------------------------------------------------------
- newForm.php: Add securimage captcha functionality to the registration form
- loginForm.php: Make login page aesthetically pleasing, with game instructions
- availableUsers.php: Handle cases of players dropping mid-match
- board.php: Core JS gameplay functions (rendering board, making moves, sync)
- Where possible, we applied template.css to as many views as possible
-------------------------------------------------------------------------------
                       Models that we modified
-------------------------------------------------------------------------------
- match_model.php: Added a function to update the game board state
-------------------------------------------------------------------------------
                               New libraries
-------------------------------------------------------------------------------
- application/libraries/securimage
- Downloaded the Securimage PHP library from their website as instructed
- We did not write this library and do not claim ownership
- We removed the audio part of the library to save space
-------------------------------------------------------------------------------
                               New CSS files
-------------------------------------------------------------------------------
- css/board.css
- Styling for the 7x6 game board (it is a HTML table with square cells)
- css/template.css
- Styling for overall aesthetics (provided by Professor De Lara)
-------------------------------------------------------------------------------
                            New JavaScript files
-------------------------------------------------------------------------------
- js/detectWin.js
- Called by the board.php view to see if the latest move made by a player results in a victory
- Checks for 4 matches in 6 different directions (row, column, 4 diagonals)
