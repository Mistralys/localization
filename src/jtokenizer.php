<?php
/**
 * Copyright (c) 2009 Tim Whitlock, http://timwhitlock.info
 *
 * Permission is hereby granted, free of charge, to any person obtaining
 * a copy of this software and associated documentation files (the
 * "Software"), to deal in the Software without restriction, including
 * without limitation the rights to use, copy, modify, merge, publish,
 * distribute, sublicense, and/or sell copies of the Software, and to
 * permit persons to whom the Software is furnished to do so, subject to
 * the following conditions:
 *
 * The above copyright notice and this permission notice shall be
 * included in all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND,
 * EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF
 * MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
 * NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE
 * LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION
 * WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *
 *
 * --
 * This library was built by the PLUG framework.
 * For original source code download the devel package from http://web.2point1.com/tag/jparser
 * Sat, 14 Nov 2009 17:19:32 +0000
 */

namespace JTokenizer;

define('P_EPSILON', -1);
define('P_EOF', -2);
define('P_GOAL', -3);

abstract class Lex
{
    private static $singletons = array();
    protected $i;
    protected $names = array(P_EPSILON => 'P_EPSILON', P_EOF => 'P_EOF', P_GOAL => 'P_GOAL',);
    protected $literals = array();

    function __construct($i = null)
    {
        if (!is_null($i)) {
            $this->i = (int)$i;
        }
    }

    function destroy()
    {
        $class = get_class($this);
        unset(self::$singletons[$class]);
        unset($this->names);
        unset($this->literals);
    }

    static function get($class)
    {
        if (!isset(self::$singletons[$class])) {
            self::$singletons[$class] = new $class;
        }

        return self::$singletons[$class];
    }

    function defined($c)
    {
        if (isset($this->literals[$c])) {
            return true;
        }
        if (!defined($c)) {
            return false;
        }
        $i = constant($c);

        return isset($this->names[$i]) && $this->names[$i] === $c;
    }

    function name($i)
    {
        if (is_int($i)) {
            if (!isset($this->names[$i])) {
                trigger_error("symbol " . var_export($i, 1) . " is unknown in " . get_class($this), E_USER_NOTICE);

                return 'UNKNOWN';
            } else {
                return $this->names[$i];
            }
        } else {
            if (!isset($this->literals[$i])) {
                trigger_error("literal symbol " . var_export($i, 1) . " is unknown in " . get_class($this), E_USER_NOTICE);
            }
        }

        return $i;
    }

    function implode($s, array $a)
    {
        $b = array();
        foreach ($a as $t) {
            $b[] = $this->name($t);
        }

        return implode($s, $b);
    }

    function dump()
    {
        asort($this->names, SORT_STRING);
        $t = max(2, strlen((string)$this->i));
        foreach ($this->names as $i => $n) {
            $i = str_pad($i, $t, ' ', STR_PAD_LEFT);
            echo "$i => $n \n";
        }
    }
}

define('J_FUNCTION', 1);
define('J_IDENTIFIER', 2);
define('J_VAR', 3);
define('J_IF', 4);
define('J_ELSE', 5);
define('J_DO', 6);
define('J_WHILE', 7);
define('J_FOR', 8);
define('J_IN', 9);
define('J_CONTINUE', 10);
define('J_BREAK', 11);
define('J_RETURN', 12);
define('J_WITH', 13);
define('J_SWITCH', 14);
define('J_CASE', 15);
define('J_DEFAULT', 16);
define('J_THROW', 17);
define('J_TRY', 18);
define('J_CATCH', 19);
define('J_FINALLY', 20);
define('J_THIS', 21);
define('J_STRING_LITERAL', 22);
define('J_NUMERIC_LITERAL', 23);
define('J_TRUE', 24);
define('J_FALSE', 25);
define('J_NULL', 26);
define('J_REGEX', 27);
define('J_NEW', 28);
define('J_DELETE', 29);
define('J_VOID', 30);
define('J_TYPEOF', 31);
define('J_INSTANCEOF', 32);
define('J_COMMENT', 33);
define('J_WHITESPACE', 34);
define('J_LINE_TERMINATOR', 35);
define('J_ABSTRACT', 36);
define('J_ENUM', 37);
define('J_INT', 38);
define('J_SHORT', 39);
define('J_BOOLEAN', 40);
define('J_EXPORT', 41);
define('J_INTERFACE', 42);
define('J_STATIC', 43);
define('J_BYTE', 44);
define('J_EXTENDS', 45);
define('J_LONG', 46);
define('J_SUPER', 47);
define('J_CHAR', 48);
define('J_FINAL', 49);
define('J_NATIVE', 50);
define('J_SYNCHRONIZED', 51);
define('J_CLASS', 52);
define('J_FLOAT', 53);
define('J_PACKAGE', 54);
define('J_THROWS', 55);
define('J_CONST', 56);
define('J_GOTO', 57);
define('J_PRIVATE', 58);
define('J_TRANSIENT', 59);
define('J_DEBUGGER', 60);
define('J_IMPLEMENTS', 61);
define('J_PROTECTED', 62);
define('J_VOLATILE', 63);
define('J_DOUBLE', 64);
define('J_IMPORT', 65);
define('J_PUBLIC', 66);
define('J_PROGRAM', 67);
define('J_ELEMENTS', 68);
define('J_ELEMENT', 69);
define('J_STATEMENT', 70);
define('J_FUNC_DECL', 71);
define('J_PARAM_LIST', 72);
define('J_FUNC_BODY', 73);
define('J_FUNC_EXPR', 74);
define('J_BLOCK', 75);
define('J_VAR_STATEMENT', 76);
define('J_EMPTY_STATEMENT', 77);
define('J_EXPR_STATEMENT', 78);
define('J_IF_STATEMENT', 79);
define('J_ITER_STATEMENT', 80);
define('J_CONT_STATEMENT', 81);
define('J_BREAK_STATEMENT', 82);
define('J_RETURN_STATEMENT', 83);
define('J_WITH_STATEMENT', 84);
define('J_LABELLED_STATEMENT', 85);
define('J_SWITCH_STATEMENT', 86);
define('J_THROW_STATEMENT', 87);
define('J_TRY_STATEMENT', 88);
define('J_STATEMENT_LIST', 89);
define('J_VAR_DECL_LIST', 90);
define('J_VAR_DECL', 91);
define('J_VAR_DECL_LIST_NO_IN', 92);
define('J_VAR_DECL_NO_IN', 93);
define('J_INITIALIZER', 94);
define('J_INITIALIZER_NO_IN', 95);
define('J_ASSIGN_EXPR', 96);
define('J_ASSIGN_EXPR_NO_IN', 97);
define('J_EXPR', 98);
define('J_EXPR_NO_IN', 99);
define('J_LHS_EXPR', 100);
define('J_CASE_BLOCK', 101);
define('J_CASE_CLAUSES', 102);
define('J_CASE_DEFAULT', 103);
define('J_CASE_CLAUSE', 104);
define('J_CATCH_CLAUSE', 105);
define('J_FINALLY_CLAUSE', 106);
define('J_PRIMARY_EXPR', 107);
define('J_ARRAY_LITERAL', 108);
define('J_OBJECT_LITERAL', 109);
define('J_ELISION', 110);
define('J_ELEMENT_LIST', 111);
define('J_PROP_LIST', 112);
define('J_PROP_NAME', 113);
define('J_MEMBER_EXPR', 114);
define('J_ARGS', 115);
define('J_NEW_EXPR', 116);
define('J_CALL_EXPR', 117);
define('J_ARG_LIST', 118);
define('J_POSTFIX_EXPR', 119);
define('J_UNARY_EXPR', 120);
define('J_MULT_EXPR', 121);
define('J_ADD_EXPR', 122);
define('J_SHIFT_EXPR', 123);
define('J_REL_EXPR', 124);
define('J_REL_EXPR_NO_IN', 125);
define('J_EQ_EXPR', 126);
define('J_EQ_EXPR_NO_IN', 127);
define('J_BIT_AND_EXPR', 128);
define('J_BIT_AND_EXPR_NO_IN', 129);
define('J_BIT_XOR_EXPR', 130);
define('J_BIT_XOR_EXPR_NO_IN', 131);
define('J_BIT_OR_EXPR', 132);
define('J_BIT_OR_EXPR_NO_IN', 133);
define('J_LOG_AND_EXPR', 134);
define('J_LOG_AND_EXPR_NO_IN', 135);
define('J_LOG_OR_EXPR', 136);
define('J_LOG_OR_EXPR_NO_IN', 137);
define('J_COND_EXPR', 138);
define('J_COND_EXPR_NO_IN', 139);
define('J_ASSIGN_OP', 140);
define('J_IGNORE', 141);
define('J_RESERVED', 142);

class JLexBase extends Lex
{
    protected $i = 142;
    protected $names = array(-3 => 'P_GOAL', -2 => 'P_EOF', -1 => 'P_EPSILON', 1 => 'J_FUNCTION', 2 => 'J_IDENTIFIER', 3 => 'J_VAR', 4 => 'J_IF', 5 => 'J_ELSE', 6 => 'J_DO', 7 => 'J_WHILE', 8 => 'J_FOR', 9 => 'J_IN', 10 => 'J_CONTINUE', 11 => 'J_BREAK', 12 => 'J_RETURN', 13 => 'J_WITH', 14 => 'J_SWITCH', 15 => 'J_CASE', 16 => 'J_DEFAULT', 17 => 'J_THROW', 18 => 'J_TRY', 19 => 'J_CATCH', 20 => 'J_FINALLY', 21 => 'J_THIS', 22 => 'J_STRING_LITERAL', 23 => 'J_NUMERIC_LITERAL', 24 => 'J_TRUE', 25 => 'J_FALSE', 26 => 'J_NULL', 27 => 'J_REGEX', 28 => 'J_NEW', 29 => 'J_DELETE', 30 => 'J_VOID', 31 => 'J_TYPEOF', 32 => 'J_INSTANCEOF', 33 => 'J_COMMENT', 34 => 'J_WHITESPACE', 35 => 'J_LINE_TERMINATOR', 36 => 'J_ABSTRACT', 37 => 'J_ENUM', 38 => 'J_INT', 39 => 'J_SHORT', 40 => 'J_BOOLEAN', 41 => 'J_EXPORT', 42 => 'J_INTERFACE', 43 => 'J_STATIC', 44 => 'J_BYTE', 45 => 'J_EXTENDS', 46 => 'J_LONG', 47 => 'J_SUPER', 48 => 'J_CHAR', 49 => 'J_FINAL', 50 => 'J_NATIVE', 51 => 'J_SYNCHRONIZED', 52 => 'J_CLASS', 53 => 'J_FLOAT', 54 => 'J_PACKAGE', 55 => 'J_THROWS', 56 => 'J_CONST', 57 => 'J_GOTO', 58 => 'J_PRIVATE', 59 => 'J_TRANSIENT', 60 => 'J_DEBUGGER', 61 => 'J_IMPLEMENTS', 62 => 'J_PROTECTED', 63 => 'J_VOLATILE', 64 => 'J_DOUBLE', 65 => 'J_IMPORT', 66 => 'J_PUBLIC', 67 => 'J_PROGRAM', 68 => 'J_ELEMENTS', 69 => 'J_ELEMENT', 70 => 'J_STATEMENT', 71 => 'J_FUNC_DECL', 72 => 'J_PARAM_LIST', 73 => 'J_FUNC_BODY', 74 => 'J_FUNC_EXPR', 75 => 'J_BLOCK', 76 => 'J_VAR_STATEMENT', 77 => 'J_EMPTY_STATEMENT', 78 => 'J_EXPR_STATEMENT', 79 => 'J_IF_STATEMENT', 80 => 'J_ITER_STATEMENT', 81 => 'J_CONT_STATEMENT', 82 => 'J_BREAK_STATEMENT', 83 => 'J_RETURN_STATEMENT', 84 => 'J_WITH_STATEMENT', 85 => 'J_LABELLED_STATEMENT', 86 => 'J_SWITCH_STATEMENT', 87 => 'J_THROW_STATEMENT', 88 => 'J_TRY_STATEMENT', 89 => 'J_STATEMENT_LIST', 90 => 'J_VAR_DECL_LIST', 91 => 'J_VAR_DECL', 92 => 'J_VAR_DECL_LIST_NO_IN', 93 => 'J_VAR_DECL_NO_IN', 94 => 'J_INITIALIZER', 95 => 'J_INITIALIZER_NO_IN', 96 => 'J_ASSIGN_EXPR', 97 => 'J_ASSIGN_EXPR_NO_IN', 98 => 'J_EXPR', 99 => 'J_EXPR_NO_IN', 100 => 'J_LHS_EXPR', 101 => 'J_CASE_BLOCK', 102 => 'J_CASE_CLAUSES', 103 => 'J_CASE_DEFAULT', 104 => 'J_CASE_CLAUSE', 105 => 'J_CATCH_CLAUSE', 106 => 'J_FINALLY_CLAUSE', 107 => 'J_PRIMARY_EXPR', 108 => 'J_ARRAY_LITERAL', 109 => 'J_OBJECT_LITERAL', 110 => 'J_ELISION', 111 => 'J_ELEMENT_LIST', 112 => 'J_PROP_LIST', 113 => 'J_PROP_NAME', 114 => 'J_MEMBER_EXPR', 115 => 'J_ARGS', 116 => 'J_NEW_EXPR', 117 => 'J_CALL_EXPR', 118 => 'J_ARG_LIST', 119 => 'J_POSTFIX_EXPR', 120 => 'J_UNARY_EXPR', 121 => 'J_MULT_EXPR', 122 => 'J_ADD_EXPR', 123 => 'J_SHIFT_EXPR', 124 => 'J_REL_EXPR', 125 => 'J_REL_EXPR_NO_IN', 126 => 'J_EQ_EXPR', 127 => 'J_EQ_EXPR_NO_IN', 128 => 'J_BIT_AND_EXPR', 129 => 'J_BIT_AND_EXPR_NO_IN', 130 => 'J_BIT_XOR_EXPR', 131 => 'J_BIT_XOR_EXPR_NO_IN', 132 => 'J_BIT_OR_EXPR', 133 => 'J_BIT_OR_EXPR_NO_IN', 134 => 'J_LOG_AND_EXPR', 135 => 'J_LOG_AND_EXPR_NO_IN', 136 => 'J_LOG_OR_EXPR', 137 => 'J_LOG_OR_EXPR_NO_IN', 138 => 'J_COND_EXPR', 139 => 'J_COND_EXPR_NO_IN', 140 => 'J_ASSIGN_OP', 141 => 'J_IGNORE', 142 => 'J_RESERVED',);
    protected $literals = array('(' => 1, ')' => 1, '{' => 1, '}' => 1, ',' => 1, ';' => 1, '=' => 1, ':' => 1, '[' => 1, ']' => 1, '.' => 1, '++' => 2, '--' => 2, '+' => 1, '-' => 1, '~' => 1, '!' => 1, '*' => 1, '/' => 1, '%' => 1, '<<' => 2, '>>' => 2, '>>>' => 3, '<' => 1, '>' => 1, '<=' => 2, '>=' => 2, '==' => 2, '!=' => 2, '===' => 3, '!==' => 3, '&' => 1, '^' => 1, '|' => 1, '&&' => 2, '||' => 2, '?' => 1, '*=' => 2, '/=' => 2, '%=' => 2, '+=' => 2, '-=' => 2, '<<=' => 3, '>>=' => 3, '>>>=' => 4, '&=' => 2, '^=' => 2, '|=' => 2,);
}

class JLex extends JLexBase
{
    protected $words = array('true' => J_TRUE, 'false' => J_FALSE, 'null' => J_NULL, 'break' => J_BREAK, 'else' => J_ELSE, 'new' => J_NEW, 'var' => J_VAR, 'case' => J_CASE, 'finally' => J_FINALLY, 'return' => J_RETURN, 'void' => J_VOID, 'catch' => J_CATCH, 'for' => J_FOR, 'switch' => J_SWITCH, 'while' => J_WHILE, 'continue' => J_CONTINUE, 'function' => J_FUNCTION, 'this' => J_THIS, 'with' => J_WITH, 'default' => J_DEFAULT, 'if' => J_IF, 'throw' => J_THROW, 'delete' => J_DELETE, 'in' => J_IN, 'try' => J_TRY, 'do' => J_DO, 'instanceof' => J_INSTANCEOF, 'typeof' => J_TYPEOF, 'abstract' => J_ABSTRACT, 'enum' => J_ENUM, 'int' => J_INT, 'short' => J_SHORT, 'boolean' => J_BOOLEAN, 'export' => J_EXPORT, 'interface' => J_INTERFACE, 'static' => J_STATIC, 'byte' => J_BYTE, 'extends' => J_EXTENDS, 'long' => J_LONG, 'super' => J_SUPER, 'char' => J_CHAR, 'final' => J_FINAL, 'native' => J_NATIVE, 'synchronized' => J_SYNCHRONIZED, 'class' => J_CLASS, 'float' => J_FLOAT, 'package' => J_PACKAGE, 'throws' => J_THROWS, 'const' => J_CONST, 'goto' => J_GOTO, 'private' => J_PRIVATE, 'transient' => J_TRANSIENT, 'debugger' => J_DEBUGGER, 'implements' => J_IMPLEMENTS, 'protected' => J_PROTECTED, 'volatile' => J_VOLATILE, 'double' => J_DOUBLE, 'import' => J_IMPORT, 'public' => J_PUBLIC,);

    function is_word($s)
    {
        return isset($this->words[$s]) ? $this->words[$s] : false;
    }

    static function singleton()
    {
        return Lex::get(__CLASS__);
    }
}

abstract class JTokenizerBase
{
    private $line;
    private $col;
    private $divmode;
    private $src;
    private $whitespace;
    private $unicode;
    private $regRegex;
    private $regDQuote;
    private $regSQuote;
    private $regWord;
    private $regWhite;
    private $regBreak;
    private $regJunk;
    private $regLines;
    private $regNumber;
    private $regComment;
    private $regCommentMulti;
    protected $regPunc;
    protected $Lex;

    function __construct($whitespace, $unicode)
    {
        $this->whitespace = $whitespace;
        $this->unicode = $unicode;
        if ($this->unicode) {
            $this->regRegex = '!^/(?:\\\\.|[^\r\n\p{Zl}\p{Zp}/\\\\])+/[gi]*!u';
            $this->regDQuote = '/^"(?:\\\\(?:.|\r\n)|[^\r\n\p{Zl}\p{Zp}"\\\\])*"/su';
            $this->regSQuote = "/^'(?:\\\\(?:.|\r\n)|[^\r\n\p{Zl}\p{Zp}'\\\\])*'/su";
            $this->regWord = '/^(?:\\\\u[0-9A-F]{4,4}|[\$_\pL\p{Nl}])(?:\\\\u[0-9A-F]{4,4}|[\$_\pL\pN\p{Mn}\p{Mc}\p{Pc}])*/ui';
            $this->regWhite = '/^[\x20\x09\x0B\x0C\xA0\p{Zs}]+/u';
            $this->regBreak = '/^[\r\n\p{Zl}\p{Zp}]+/u';
            $this->regJunk = '/^./u';
            $this->regLines = '/(\r\n|[\r\n\p{Zl}\p{Zp}])/u';
        } else {
            $this->regRegex = '!^/(?:\\\\.|[^\r\n/\\\\])+/[gi]*!';
            $this->regDQuote = '/^"(?:\\\\(?:.|\r\n)|[^\r\n"\\\\])*"/s';
            $this->regSQuote = "/^'(?:\\\\(?:.|\r\n)|[^\r\n'\\\\])*'/s";
            $this->regWord = '/^[\$_A-Z][\$_A-Z0-9]*/i';
            $this->regWhite = '/^[\x20\x09\x0B\x0C\xA0]+/';
            $this->regBreak = '/^[\r\n]+/';
            $this->regJunk = '/^./';
            $this->regLines = '/(\r\n|\r|\n)/';
        }
        $this->regNumber = '/^(?:0x[A-F0-9]+|\d*\.\d+(?:E(?:\+|\-)?\d+)?|\d+)/i';
        $this->regComment = '/^\/\/.*/';
        $this->regCommentMulti = '/^\/\*.*\*\//Us';
    }

    function init($src)
    {
        $this->src = $src;
        $this->line = 1;
        $this->col = 1;
        $this->divmode = false;
    }

    function get_all_tokens($src)
    {
        $this->init($src);
        $tokens = array();
        while ($this->src) {
            $token = $this->get_next_token() and $tokens[] = $token;
        }

        return $tokens;
    }

    function get_next_token()
    {
        $r = null;
        
        $c = $this->src{0};
        if ($c === '"') {
            if (!preg_match($this->regDQuote, $this->src, $r)) {
                trigger_error("Unterminated string constant on line $this->line", E_USER_NOTICE);
                $s = $t = '"';
            } else {
                $s = $r[0];
                $t = J_STRING_LITERAL;
            }
            $this->divmode = true;
        } else if ($c === "'") {
            if (!preg_match($this->regSQuote, $this->src, $r)) {
                trigger_error("Unterminated string constant on line $this->line", E_USER_NOTICE);
                $s = $t = "'";
            } else {
                $s = $r[0];
                $t = J_STRING_LITERAL;
            }
            $this->divmode = true;
        } else {
            if ($c === '/') {
                if ($this->src{1} === '/' && preg_match($this->regComment, $this->src, $r)) {
                    $t = $this->whitespace ? J_COMMENT : false;
                    $s = $r[0];
                } else {
                    if ($this->src{1} === '*' && preg_match($this->regCommentMulti, $this->src, $r)) {
                        $s = $r[0];
                        if ($this->whitespace) {
                            $t = J_COMMENT;
                        } else {
                            $breaks = preg_match($this->regLines, $s, $r);
                            $t = $breaks ? J_LINE_TERMINATOR : false;
                        }
                    } else {
                        if (!$this->divmode) {
                            if (!preg_match($this->regRegex, $this->src, $r)) {
                                trigger_error("Bad regular expression literal on line $this->line", E_USER_NOTICE);
                                $s = $t = '/';
                                $this->divmode = false;
                            } else {
                                $s = $r[0];
                                $t = J_REGEX;
                                $this->divmode = true;
                            }
                        } else {
                            if ($this->src{1} === '=') {
                                $s = $t = '/=';
                                $this->divmode = false;
                            } else {
                                $s = $t = '/';
                                $this->divmode = false;
                            }
                        }
                    }
                }
            } else {
                if (preg_match($this->regBreak, $this->src, $r)) {
                    $t = J_LINE_TERMINATOR;
                    $s = $r[0];
                    $this->divmode = false;
                } else {
                    if (preg_match($this->regWhite, $this->src, $r)) {
                        $t = $this->whitespace ? J_WHITESPACE : false;
                        $s = $r[0];
                    } else {
                        if (preg_match($this->regNumber, $this->src, $r)) {
                            $t = J_NUMERIC_LITERAL;
                            $s = $r[0];
                            $this->divmode = true;
                        } else {
                            if (preg_match($this->regWord, $this->src, $r)) {
                                $s = $r[0];
                                $t = $this->Lex->is_word($s) or $t = J_IDENTIFIER;
                                switch ($t) {
                                    case J_IDENTIFIER;
                                        $this->divmode = true;
                                        break;
                                    default:
                                        $this->divmode = null;
                                }
                            } else {
                                if (preg_match($this->regPunc, $this->src, $r)) {
                                    $s = $t = $r[0];
                                    switch ($t) {
                                        case ']':
                                        case ')':
                                            $this->divmode = true;
                                            break;
                                        default:
                                            $this->divmode = false;
                                    }
                                } else {
                                    preg_match($this->regJunk, $this->src, $r);
                                    $s = $t = $r[0];
                                    trigger_error("Junk on line $this->line, $s", E_USER_NOTICE);
                                }
                            }
                        }
                    }
                }
            }
        }
        $len = strlen($s);
        if ($len === 0) {
            throw new Exception('Failed to extract anything');
        }
        if ($t !== false) {
            $token = array($t, $s, $this->line, $this->col);
        }
        $this->src = substr($this->src, $len);
        if ($t === J_LINE_TERMINATOR || $t === J_COMMENT) {
            $this->line += preg_match_all($this->regLines, $s, $r);
            $cbreak = chr(end($r[0]));
            
            $this->col = $len - strrpos($s, $cbreak);
        } else {
            $this->col += $len;
        }

        return isset($token) ? $token : null;
    }
}

class JTokenizer extends JTokenizerBase
{
    protected $regPunc = '/(?:\>\>\>\=|\>\>\>|\<\<\=|\>\>\=|\!\=\=|\=\=\=|&&|\<\<|\>\>|\|\||\*\=|\|\=|\^\=|&\=|%\=|-\=|\+\+|\+\=|--|\=\=|\>\=|\!\=|\<\=|;|,|\<|\>|\.|\]|\}|\(|\)|\[|\=|\:|\||&|-|\{|\^|\!|\?|\*|%|~|\+)/';

    function __construct($whitespace, $unicode)
    {
        parent::__construct($whitespace, $unicode);
        $this->Lex = Lex::get('JLex');
    }
    
    public static function getTokens($src, $whitespace = true, $unicode = true)
    {
        $Tokenizer = new JTokenizer($whitespace, $unicode);
        
        return $Tokenizer->get_all_tokens($src);
    }
}
