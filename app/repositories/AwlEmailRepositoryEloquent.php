<?php

namespace Bausch\Repositories;

use Bausch\Models\AwlEmail as Email;

class AwlEmailRepositoryEloquent implements AwlEmailRepositoryInterface {

    public function findAll() {
        $data = Email::orderBy('sender_name', 'asc')->get();

        return $data;
    }

    public function instance($data = array()) {
        return new Email($data);
    }

    public function store(Email $email) {
        return Email::insert(array(
                    'sender_name' => $email->getSenderName(),
                    'sender_domain' => $email->getSenderDomain(),
                    'src' => $email->getSource(),
                    'first_seen' => $email->getFirstSeen(),
                    'last_seen' => $email->getLastSeen(),
        ));
    }

    public function destroy(Email $email) {
        return Email::where('sender_name', $email->getSenderName())
                        ->where('sender_domain', $email->getSenderDomain())
                        ->where('src', $email->getSource())
                        ->delete();
    }

}
