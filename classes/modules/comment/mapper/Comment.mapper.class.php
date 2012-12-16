<?php
/*-------------------------------------------------------
 *
*   kEditComment.
*   Copyright © 2012 Alexei Lukin
*
*--------------------------------------------------------
*
*   Official site: http://kerbystudio.ru
*   Contact e-mail: kerby@kerbystudio.ru
*
---------------------------------------------------------
*/

class PluginEditcomment_ModuleComment_MapperComment extends PluginEditcomment_Inherit_ModuleComment_MapperComment
{

    public function UpdateEditCommentData(ModuleComment_EntityComment $oComment)
    {
        $sql="UPDATE " . Config::Get('db.table.comment') . "
        SET
        comment_edit_count= ?d,
        comment_edit_date=?
        WHERE
        comment_id = ?d
        ";
        if ($this->oDb->query($sql, $oComment->getEditCount(), $oComment->getEditDate(), $oComment->getId()) !== false)
        {
            return true;
        }
        return false;
    }

    public function AddComment(ModuleComment_EntityComment $oComment)
    {
        $iId=parent::AddComment($oComment);
        if ($iId)
        {
            $oComment->setId($iId);
            $oComment->setEditDate($oComment->getDate());
            $this->UpdateEditCommentData($oComment);
        }
        
        return $iId;
    }

    public function UpdateComment(ModuleComment_EntityComment $oComment)
    {
        parent::UpdateComment($oComment);
        return $this->UpdateEditCommentData($oComment);
    }

}
?>