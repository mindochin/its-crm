<?php
/**
 * Description of MyCCaptchaAction
 *
 * @author vladdis
 */
class MyCCaptchaAction extends CCaptchaAction
{
    public function renderImage($code)
    {
        parent::renderImage($this->showCode($code));
    }

    protected function showCode($code) {
        $rand = rand(1, (int)$code-1);
        return (rand(0, 1)) ? (int)$code-$rand."+".(int)$rand : (int)$code+$rand."-".(int)$rand;
    }

    protected function generateVerifyCode()
    {
        return rand((int)$this->minLength, (int)$this->maxLength);
    }
}
?>
