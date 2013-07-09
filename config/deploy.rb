# SERVER
set :domain,  "yago.webfactional.com"
set :user,    "yago"

# NAME
set :application, "tasko"

# REPOSITORY
set :repository, "git@github.com:Yago31/tasko.git"

server "#{domain}", :app, :web, :db, :primary => true

set :deploy_via, :copy
set :copy_exclude, [".git", ".DS_Store"]
set :scm, :git
set :branch, "master"
# set this path to be correct on yoru server
set :deploy_to, "/home/yago/webapps/#{application}"
set :use_sudo, false
set :git_shallow_clone, 1
set :keep_releases, 10

ssh_options[:paranoid] = false


namespace :deploy do

  desc <<-DESC
  A macro-task that updates the code and fixes the symlink.
  DESC
  task :default do
    transaction do
      update_code
      symlink
    end
  end

  task :update_code, :except => { :no_release => true } do
    on_rollback { run "rm -rf #{release_path}; true" }
    strategy.deploy!
  end

  task :after_deploy do
    cleanup
  end

end



after "deploy:update_code", "deploy:cleanup"

