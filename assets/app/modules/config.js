module.exports = {
    API_ROOT: 'http://ds3.loc/request.php?url=http://api.ds3.loc/',
    get API_PATH () {
        return this.API_ROOT + 'api/v1/';
    }
}