<?php

namespace Query\Relations;

class UsersFollowCategories extends \Query\Query
{
    public function relationWithUserIDAndCategoryID(int $userID, int $followedCategoryID)
    {
        $sql = 'SELECT * FROM er_users_follow_categories WHERE user_id=:user_id AND category_id=:category_id LIMIT 1';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userID, \PDO::PARAM_INT);
        $stmt->bindParam(':category_id', $followedCategoryID, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        if (!$row = $stmt->fetch(\PDO::FETCH_ASSOC)) {
            return;
        }

        return \Model\Relation\UserFollowCategory::initWithDBState($row);
    }

    /**
     * List of categories that this specific user is following.
     */
    public function findCategoriesFollowedByUser(int $userID)
    {
        $sql = 'SELECT category_id FROM er_users_follow_categories WHERE (user_id=:user_id)';
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':user_id', $userID, \PDO::PARAM_INT);
        if (!$stmt->execute()) {
            $error = $stmt->errorInfo();

            throw new \Exception($error[2], $error[1]);
        }

        $results = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $follows_categories = [];
        foreach ($results as $row) {
            $follows_categories[] = (int) $row['category_id'];
        }

        return $follows_categories;
    }
}
