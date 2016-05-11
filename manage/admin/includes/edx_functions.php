<?php
namespace Ds3\Libraries\Legacy;

/**
 * Auxiliary function to call the edX scripts, that communicate with edX
 *
 * @param string $instruction
 * @param array  $parameters
 * @return string|bool
 */
function edx_command ($instruction, Array $parameters) {
    $instructions = [
        'login' => 'edxScript.sh',
        'new' => 'edxNewUser.sh',
        'edit' => 'edxEditUser.sh',
        'delete' => 'edxDeleteUser.sh'
    ];

    if (!array_key_exists($instruction, $instructions)) {
        return false;
    }

    array_walk($parameters, function (&$each) {
        $each = '"' . urlencode($each) . '"';
    });

    $baseDir = __DIR__ . '/../..';
    $command = "sh $baseDir/edx_scripts/{$instructions[$instruction]} " . join(' ', $parameters);
    $lastLine = exec($command, $output, $returnCode);

    return $lastLine;
}

/**
 * Update edX details for a given user id.
 *
 * For users with different username in DSS and edX, this call would fail and the user could not log in.
 * edX required a modification in the following file:
 *
 * /edx/app/edxapp/edx-platform-dss/cms/djangoapps/make_session_data/views.py
 *
 * Original:
 *
 * def create_new_user(request):
 *      if request.META['REMOTE_ADDR'] in allowed_ips:
 *          if request.method == "POST":
 *              form = createUserForm(request.POST)
 *              if form.is_valid():
 *                  user = User(username=request.POST['username'], email=request.POST['email'], is_active=True)
 *                  user.set_password(request.POST['password'])
 *                  try:
 *                      user.save()
 *                  except IntegrityError:
 *                      return HttpResponse('User already exists')
 *
 * Modified:
 *
 * def create_new_user(request):
 *      if request.META['REMOTE_ADDR'] in allowed_ips:
 *          if request.method == "POST":
 *              form = createUserForm(request.POST)
 *              if form.is_valid():
 *                  user = User(username=request.POST['username'], email=request.POST['email'], is_active=True)
 *                  user.set_password(request.POST['password'])
 *                  try:
 *                      user.save()
 *                  except IntegrityError:
 *                      if User.objects.filter(username=request.POST['username']).exists():
 *                          existing = User.objects.get(username=request.POST['username'])
 *                          return HttpResponse("User already exists: {id}".format(id=existing.id))
 *                      elif User.objects.filter(email=request.POST['email']).exists():
 *                          existing = User.objects.get(email=request.POST['email'])
 *                          return HttpResponse("User already exists: {id}".format(id=existing.id))
 *                      else:
 *                          return HttpResponse('User already exists')
 *
 * @param int $userId
 */
function edx_user_update ($userId) {
    $db = new Db();
    $id = intval($userId);

    $sql = "SELECT username, email, first_name, last_name, edx_id
          FROM dental_users
          WHERE userid = '$userId'";

    $user = $db->getRow($sql);
    $edxId = $user['edx_id'];
    $password = sha1($user['username'] . 'ed&$s8e' . $user['email'] . rand());

    if (!$edxId) {
        $parameters = [
            $user['username'],
            $user['email'],
            $password,
            "{$user['first_name']} {$user['last_name']}"
        ];

        $response = edx_command('new', $parameters);

        if (preg_match('/^(User already exists: )?(?P<edx_id>\d+)$/', $response, $match)) {
            $edxId = $match['edx_id'];

            $sql = "UPDATE dental_users
                SET edx_id = '" . $db->escape($edxId) . "'
                WHERE userid = '$userId'";
            $db->query($sql);
        }
    }

    if ($edxId) {
        $parameters = [
            $edxId,
            $user['username'],
            $user['email'],
            $password,
            "{$user['first_name']} {$user['last_name']}"
        ];

        edx_command('edit', $parameters);
    }
}

/**
 * Delete edX profile, give the edx id instead of the user id
 *
 * @param int $edxId
 */
function edx_user_delete ($edxId) {
    if ($edxId) {
        edx_command('delete', [$edxId]);
    }
}

/**
 * Retrieve the edx session id for the given user id, if the associated edx id is valid
 *
 * @param int $userId
 * @return string|bool
 */
function edx_user_login ($userId) {
    $db = new Db();

    $userId = intval($userId);
    $edxId = $db->getColumn("SELECT edx_id
        FROM dental_users
        WHERE userid = '$userId'", 'edx_id', 0);

    $sessionId = edx_command('login', [$edxId]);
    return $sessionId;
}
