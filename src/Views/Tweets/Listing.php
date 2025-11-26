<?php

namespace Views\Tweets;

use Entity\User;

class Listing
{
    protected $user;
    protected $tweets;
    protected $tweetsCount;

    public function __construct(User $user, array $tweets, int $tweetsCount)
    {
        $this->user = $user;
        $this->tweets = $tweets;
        $this->tweetsCount = $tweetsCount;
    }

    public function __invoke(): void
    {
        $userId = htmlspecialchars($this->user->id);
        $userName = htmlspecialchars($this->user->name);
        ?>
        <div class="col-sm-8 col-sm-offset-2">
            <div class="panel panel-default" style="margin-bottom: 20px;">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-xs-3">
                            <a href="/<?= $userId ?>" title="<?= $userName ?>" rel="noopener">
                                <img alt="@<?= $userId ?> avatar" class="img-rounded" src="/img/<?= $userId ?>" style="width: 64px; height: 64px;">
                            </a>
                        </div>
                        <div class="col-xs-6">
                            <div>
                                <a href="/<?= $userId ?>" rel="noopener"><strong class="fullname"><?= $userName ?></strong></a>
                            </div>
                            <span dir="ltr">
                                <a href="/<?= $userId ?>" rel="noopener">@<span><?= $userId ?></span></a>
                            </span>
                        </div>
                        <div class="col-xs-3 text-center">
                            <h5>
                                <small>TWEETS</small>
                                <a href="#"><?= $this->tweetsCount ?></a>
                            </h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-info">
                <div class="panel-body">
                <?php
                if (empty($this->tweets)) {
                    echo "<p>$userName has not tweeted yet!</p>";
                } else {
                    /** @var \Entity\Tweet $tweet */
                    foreach ($this->tweets as $tweet) {
                        ?>
                        <div class="media">
                            <a class="media-left" href="/<?= $userId ?>">
                                <img alt="@<?= $userId ?> avatar" class="img-rounded" src="/img/<?= $userId ?>">
                            </a>
                            <div class="media-body">
                                <a href="/<?= $userId ?>"><strong class="fullname"><?= $userName ?></strong></a>
                                <a href="/<?= $userId ?>">@<?= $userId ?></a> <small class="time"><a href="/<?= "$userId/status/" . htmlspecialchars($tweet->id) ?>"><?= $tweet->ts ?></a></small>
                                <p><?= htmlspecialchars($tweet->message) ?></p>
                            </div>
                        </div>
                        <?php
                    }
                }
                ?>
                </div>
            </div>
        </div>
        <?php
    }
}
