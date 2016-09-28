module.exports = (grunt) ->
  @initConfig
    pkg: @file.readJSON('package.json')
    coffee:
      compileAdmin:
        options:
          bare: true
          sourceMap: true
        expand: true
        cwd: 'js/src/admin/coffee'
        src: ['*.coffee']
        dest: 'js/src/admin/'
        ext: '.js'
      compilePublic:
        options:
          bare: true
          sourceMap: true
        expand: true
        cwd: 'js/src/public/coffee'
        src: ['*.coffee']
        dest: 'js/src/public/'
        ext: '.js'
    compress:
      main:
        options:
          archive: '<%= pkg.name %>.zip'
        files: [
          {src: ['fields/**']},
          {src: ['img/**']},
          {src: ['src/**']},
          {src: ['vendor/**', '!vendor/composer/autoload_static.php']},
          {src: ['view/**']},
          {src: ['agrilife-extension-unit.php']},
          {src: ['README.md']}
        ]
    gh_release:
      options:
        token: process.env.RELEASE_KEY
        owner: 'agrilife'
        repo: '<%= pkg.name %>'
      release:
        tag_name: '<%= pkg.version %>'
        target_commitish: 'master'
        name: 'Release'
        body: 'First release'
        draft: false
        prerelease: false
        asset:
          name: '<%= pkg.name %>.zip'
          file: '<%= pkg.name %>.zip'
          'Content-Type': 'application/zip'

  @loadNpmTasks 'grunt-contrib-coffee'
  @loadNpmTasks 'grunt-contrib-compress'
  @loadNpmTasks 'grunt-gh-release'
  @loadNpmTasks 'grunt-gitinfo'

  @registerTask 'release', ['compress', 'setreleasemsg', 'gh_release']
  @registerTask 'setreleasemsg', 'Set release message as range of commits', ->
    done = @async()
    grunt.util.spawn {
      cmd: 'git'
      args: [ 'tag' ]
    }, (err, result, code) ->
      if(result.stdout!='')
        matches = result.stdout.match(/([^\n]+)$/)
        releaserange = matches[1] + '..HEAD'
        grunt.config.set 'releaserange', releaserange
        grunt.task.run('shortlog');
      done(err)
      return
    return
  @registerTask 'shortlog', 'Set gh_release body with commit messages since last release', ->
    done = @async()
    grunt.util.spawn {
      cmd: 'git'
      args: ['shortlog', grunt.config.get('releaserange'), '--no-merges']
    }, (err, result, code) ->
      if(result.stdout != '')
        grunt.config 'gh_release.release.body', result.stdout.replace(/(\n)\s\s+/g, '$1- ')
      else
        grunt.config 'gh_release.release.body', 'release'
      done(err)
      return
    return

  @event.on 'watch', (action, filepath) =>
    @log.writeln('#{filepath} has #{action}')