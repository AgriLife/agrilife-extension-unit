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
          archive: grunt.file.readJSON('package.json').name + '.zip'
        files: [
          {src: ['fields/**']},
          {src: ['img/**']},
          {src: ['src/**']},
          {src: ['vendor/**', '!vendor/composer/autoload_static.php']},
          {src: ['view/**']},
          {src: ['agrilife-extension-unit.php']},
          {src: ['README.md']}
        ]
    gitinfo:
      commands:
        'lastUpdate': ['log', '-1', '--pretty=format:"%s"', '--no-merges']
    gh_release:
      options:
        token: process.env.RELEASE_KEY
        owner: 'agrilife'
        repo: grunt.file.readJSON('package.json').name
      release:
        tag_name: grunt.file.readJSON('package.json').version
        target_commitish: 'master'
        name: 'Release'
        body: '<%= gitinfo.lastUpdate %>'
        draft: false
        prerelease: false
        asset:
          name: grunt.file.readJSON('package.json').name + '.zip'
          file: grunt.file.readJSON('package.json').name + '.zip'
          'Content-Type': 'application/zip'

  @loadNpmTasks 'grunt-contrib-coffee'
  @loadNpmTasks 'grunt-contrib-compress'
  @loadNpmTasks 'grunt-gh-release'
  @loadNpmTasks 'grunt-gitinfo'

  @registerTask 'release', ['gitinfo', 'compress', 'gh_release']

  @event.on 'watch', (action, filepath) =>
    @log.writeln('#{filepath} has #{action}')