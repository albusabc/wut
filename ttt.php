<?php
session_start();

if (!isset($_SESSION['board'])) {
    $_SESSION['board'] = [
        ['', '', ''],
        ['', '', ''],
        ['', '', '']
    ];
    $_SESSION['player'] = 'X';
    $_SESSION['message'] = '';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $row = $_POST['row'];
    $col = $_POST['col'];

    if ($_SESSION['board'][$row][$col] === '' && $_SESSION['message'] === '') {
        $_SESSION['board'][$row][$col] = $_SESSION['player'];
        if (checkWin($_SESSION['board'], $_SESSION['player'])) {
            $_SESSION['message'] = 'Player ' . $_SESSION['player'] . ' wins!';
        } elseif (checkDraw($_SESSION['board'])) {
            $_SESSION['message'] = 'It\'s a draw!';
        } else {
            $_SESSION['player'] = $_SESSION['player'] === 'X' ? 'O' : 'X';
        }
    }
}

function checkWin($board, $player) {
    // Check rows
    for ($i = 0; $i < 3; $i++) {
        if ($board[$i][0] === $player && $board[$i][1] === $player && $board[$i][2] === $player) {
            return true;
        }
    }
    // Check columns
    for ($i = 0; $i < 3; $i++) {
        if ($board[0][$i] === $player && $board[1][$i] === $player && $board[2][$i] === $player) {
            return true;
        }
    }
    // Check diagonals
    if ($board[0][0] === $player && $board[1][1] === $player && $board[2][2] === $player) {
        return true;
    }
    if ($board[0][2] === $player && $board[1][1] === $player && $board[2][0] === $player) {
        return true;
    }
    return false;
}

function checkDraw($board) {
    for ($i = 0; $i < 3; $i++) {
        for ($j = 0; $j < 3; $j++) {
            if ($board[$i][$j] === '') {
                return false;
            }
        }
    }
    return true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Tic Tac Toe</title>
    <style>
        table {
            border-collapse: collapse;
            margin: 20px auto;
        }
        td {
            width: 60px;
            height: 60px;
            text-align: center;
            vertical-align: middle;
            font-size: 24px;
            border: 1px solid black;
        }
        .message {
            text-align: center;
            font-size: 24px;
            margin-top: 20px;
        }
        .reset {
            display: block;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>

<h1 style="text-align: center;">Tic Tac Toe</h1>
<table>
    <?php for ($i = 0; $i < 3; $i++): ?>
        <tr>
            <?php for ($j = 0; $j < 3; $j++): ?>
                <td>
                    <?php if ($_SESSION['board'][$i][$j] === ''): ?>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="row" value="<?php echo $i; ?>">
                            <input type="hidden" name="col" value="<?php echo $j; ?>">
                            <button type="submit" style="width: 100%; height: 100%;"></button>
                        </form>
                    <?php else: ?>
                        <?php echo $_SESSION['board'][$i][$j]; ?>
                    <?php endif; ?>
                </td>
            <?php endfor; ?>
        </tr>
    <?php endfor; ?>
</table>

<div class="message">
    <?php echo $_SESSION['message']; ?>
</div>

<div class="reset">
    <?php if ($_SESSION['message'] !== ''): ?>
        <form method="post" action="reset.php">
            <button type="submit">Start New Game</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>
