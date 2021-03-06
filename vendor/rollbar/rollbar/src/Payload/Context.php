<?php namespace Rollbar\Payload;

class Context implements \JsonSerializable
{
    private $pre;
    private $post;
    private $utilities;

    public function __construct($pre, $post)
    {
        $this->utilities = new \Rollbar\Utilities();
        $this->setPre($pre);
        $this->setPost($post);
    }

    public function getPre()
    {
        return $this->pre;
    }

    public function setPre($pre)
    {
        $this->validateAllString($pre, "pre");
        $this->pre = $pre;
        return $this;
    }

    public function getPost()
    {
        return $this->post;
    }

    public function setPost($post)
    {
        $this->validateAllString($post, "post");
        $this->post = $post;
        return $this;
    }

    public function jsonSerialize()
    {
        $result = get_object_vars($this);
        unset($result['utilities']);
        return $this->utilities->serializeForRollbar($result);
    }

    private function validateAllString($arr, $arg)
    {
        foreach ($arr as $line) {
            if (!is_string($line)) {
                throw new \InvalidArgumentException("\$$arg must be all strings");
            }
        }
    }
}
