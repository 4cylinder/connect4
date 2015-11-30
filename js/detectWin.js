/******************************************************************************
* Tzuo Shuin Yew (997266499)
* Chia-Heng Lin (997530970)
* April 4, 2014
* @file detectWin.js
* @brief client-side detection of winning scenarios on the connect-four board
* @details When the user makes a move, this file checks if it's a winning move
******************************************************************************/
// 2D array, initially every element is empty
var board = [];
var COLS = 7;
var ROWS = 6;
// Initialize the board to be all blank
for (var i=0; i<ROWS; i++){
	board[i] = [];
	for (var j=0;j<COLS;j++){
		board[i][j] = "";
	}
}
/*******************************************************************************
* @brief Mark the 2D array by placing players' usernames into filled cells
* @param filled Array of filled cells sent by views/match/board.php
* @return Nothing
*******************************************************************************/
function populate (filled){
	// each key of the associative array is of the form x*y*
	// e.g. if cell (0,0) is filled, the key is x0y0
	for (var key in filled) {
		var i = key[3];
		var j = key[1];
		// the value associated with the key is the username of the player
		// who filled in that particulate cell
		board[i][j] = filled[key];
	}
}
/*******************************************************************************
* @brief Check for 4 consecutive matches in the same column
* @param col The column of the cell where the player made his last move
* @param user The player's username (matching cells will contain it)
* @return True if there are 4 matches, False otherwise
*******************************************************************************/
function checkColumn(col, user) {
	var count = 0;
	for (var i=0; i<ROWS; i++){
		if (board[i][col]==user)
			count++;
		else if (count>0)
			break;
	}
	return (count>=4);
}
/*******************************************************************************
* @brief Check for 4 consecutive matches in the same row
* @param row The row of the cell where the player made his last move
* @param user The player's username (matching cells will contain it)
* @return True if there are 4 matches, False otherwise
*******************************************************************************/
function checkRow(row, user){
	var count = 0;
	for (var j=0; j<COLS; j++){
		if (board[row][j]==user)
			count++;
		else if (count>0)
			break;
	}
	return (count>=4);
}
/*******************************************************************************
* @brief Check for 4 consecutive matches in the same diagonal (going southeast)
* @param row The row of the cell where the player made his last move
* @param col The column of the cell where the player made his last move
* @param user The player's username (matching cells will contain it)
* @return True if there are 4 matches, False otherwise
*******************************************************************************/
function checkDiagonalSE(row,col,user){
	var count = 0;
	// If possible, start counting matches from the northwest neighbour
	var i=row-1;
	var j=col-1;
	// If the cell is at the leftmost column and/or the topmost row, there
	// isn't a northwest neighbour. So start counting from the cell itself.
	if (row==0 || col==0){
		i = row;
		j = col;
	}
	while(i<ROWS && j<COLS){
		if (board[i][j]==user)
			count++;
		else if (count>0)
			break;
		i++;
		j++;
	}
	return (count>=4);
}
/*******************************************************************************
* @brief Check for 4 consecutive matches in the same diagonal (going northwest)
* @param row The row of the cell where the player made his last move
* @param col The column of the cell where the player made his last move
* @param user The player's username (matching cells will contain it)
* @return True if there are 4 matches, False otherwise
*******************************************************************************/
function checkDiagonalNW(row,col,user){
	var count = 0;
	// If possible, start counting matches from the southeast neighbour
	var i=row+1;
	var j=col+1;
	// If the cell is at the rightmost column and/or the bottommost row, there
	// isn't a southeast neighbour. So start counting from the cell itself.
	if (row==ROWS-1 || col==COLS-1){
		i = row;
		j = col;
	}
	while(i>=0 && j>=0){
		if (board[i][j]==user)
			count++;
		else if (count>0)
			break;
		i--;
		j--;
	}
	return (count>=4);
}
/*******************************************************************************
* @brief Check for 4 consecutive matches in the same diagonal (going northeast)
* @param row The row of the cell where the player made his last move
* @param col The column of the cell where the player made his last move
* @param user The player's username (matching cells will contain it)
* @return True if there are 4 matches, False otherwise
*******************************************************************************/
function checkDiagonalNE(row,col,user){
	var count = 0;
	// If possible, start counting matches from the southwest neighbour
	var i=row+1, j=col-1;
	// If the cell is at the leftmost column and/or the bottommost row, there
	// isn't a southwest neighbour. So start counting from the cell itself.
	if (row==ROWS-1 || col==0){
		i = row;
		j = col;
	}
	while(i>=0 && j<COLS){
		if (board[i][j]==user)
			count++;
		else if (count>0)
			break;
		i--;
		j++;
	}
	return (count>=4);
}
/*******************************************************************************
* @brief Check for 4 consecutive matches in the same diagonal (going southwest)
* @param row The row of the cell where the player made his last move
* @param col The column of the cell where the player made his last move
* @param user The player's username (matching cells will contain it)
* @return True if there are 4 matches, False otherwise
*******************************************************************************/
function checkDiagonalSW(row,col,user){
	var count = 0;
	// If possible, start counting matches from the northeast neighbour
	var i=row-1, j=col+1;
	// If the cell is at the rightmost column and/or the topmost row, there
	// isn't a northeast neighbour. So start counting from the cell itself.
	if (row==0 || col==COLS-1){
		i = row;
		j = col;
	}
	while(i<ROWS && j>=0){
		if (board[i][j]==user)
			count++;
		else if (count>0)
			break;
		i++;
		j--;
	}
	return (count>=4);
}
/*******************************************************************************
* @brief Call the above helper functions (populate array then check for matches)
* @param row The row of the cell where the player made his last move
* @param col The column of the cell where the player made his last move
* @param user The player's username (matching cells will contain it)
* @param filled Array of filled cells sent by views/match/board.php
* @return True if the last move is a winning move, False otherwise
*******************************************************************************/
function checkWin(row,col,user,filled) {
	populate(filled);
	return (checkColumn(col,user) || checkRow(row,user) || checkDiagonalNW(row,col,user)
		|| checkDiagonalSE(row,col,user) || checkDiagonalSW(row,col,user) || 
		checkDiagonalNE(row,col,user));
}
