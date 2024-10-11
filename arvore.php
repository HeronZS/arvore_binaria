<?php

class Node {
    public $value;
    public $left;
    public $right;

    public function __construct($value) {
        $this->value = $value;
        $this->left = null;
        $this->right = null;
    }
}

class BinaryTree {
    public $root;

    public function __construct() {
        $this->root = null;
    }

    public function insert($value) {
        $this->root = $this->insertRecursive($this->root, $value);
    }

    private function insertRecursive($node, $value) {
        if ($node === null) {
            return new Node($value);
        } elseif ($value < $node->value) {
            $node->left = $this->insertRecursive($node->left, $value);
        } else {
            $node->right = $this->insertRecursive($node->right, $value);
        }
        return $node;
    }

    public function remove($value) {
        $this->root = $this->removeRecursive($this->root, $value);
    }

     public function clear() {
        $this->root = null;
    }

    private function removeRecursive($node, $value) {
        if ($node === null) {
            return null;
        }
        if ($value < $node->value) {
            $node->left = $this->removeRecursive($node->left, $value);
        } elseif ($value > $node->value) {
            $node->right = $this->removeRecursive($node->right, $value);
        } else {
            if ($node->left === null) return $node->right;
            if ($node->right === null) return $node->left;

            $minValue = $this->findMin($node->right);
            $node->value = $minValue;
            $node->right = $this->removeRecursive($node->right, $minValue);
        }
        return $node;
    }

    private function findMin($node) {
        while ($node->left !== null) {
            $node = $node->left;
        }
        return $node->value;
    }

    public function preOrder($node) {
        if ($node !== null) {
            echo $node->value . " ";
            $this->preOrder($node->left);
            $this->preOrder($node->right);
        }
    }

    public function inOrder($node) {
        if ($node !== null) {
            $this->inOrder($node->left);
            echo $node->value . " ";
            $this->inOrder($node->right);
        }
    }

    public function postOrder($node) {
        if ($node !== null) {
            $this->postOrder($node->left);
            $this->postOrder($node->right);
            echo $node->value . " ";
        }
    }

    public function height($node) {
        if ($node === null) return 0;
        return max($this->height($node->left), $this->height($node->right)) + 1;
    }

    public function level($node, $value, $currentLevel = 0) {
        if ($node === null) return -1;
        if ($node->value === $value) return $currentLevel;

        if ($value < $node->value) {
            return $this->level($node->left, $value, $currentLevel + 1);
        } else {
            return $this->level($node->right, $value, $currentLevel + 1);
        }
    }

    public function countLeaves($node) {
        if ($node === null) return 0;
        if ($node->left === null && $node->right === null) return 1;
        return $this->countLeaves($node->left) + $this->countLeaves($node->right);
    }

    public function isComplete($node, $index = 0, $nodeCount = null) {
        if ($nodeCount === null) $nodeCount = $this->countNodes($this->root);
        if ($node === null) return true;
        if ($index >= $nodeCount) return false;
        return $this->isComplete($node->left, 2 * $index + 1, $nodeCount) &&
               $this->isComplete($node->right, 2 * $index + 2, $nodeCount);
    }

    private function countNodes($node) {
        if ($node === null) return 0;
        return 1 + $this->countNodes($node->left) + $this->countNodes($node->right);
    }
}
