import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Axios from 'axios';

import Task from './Task'
import TaskInput from './TaskInput'

export default class TodoApp extends Component {
  constructor() {
    super();

    this.state = {
      tasks: [],
      newTask: ''
    }
  }


  componentDidMount() {
    axios.get('/tasks')
      .then(res => res.data.data)
      .then(tasks => this.setState({ tasks }))
  }


  add(task) {
    Axios
      .post('/tasks', task)
      .then(res => res.data.data)
      .then(task => this.setState(state => {
        const tasks = state.tasks.concat(task)

        return {
          tasks,
          newTask: ''
        };
      }))
  }


  update(taskToUpdate, newBody) {
    Axios
      .patch(`/tasks/${taskToUpdate.id}`, { body: newBody })
      .then(() => this.setState(state => {
        const tasks = state.tasks.map(function (task) {
          return task !== taskToUpdate ? task : { ...task, body: newBody }
        })

        return {
          tasks,
          editing: null
        };
      }))
  }


  destroy(taskToRemove) {
    Axios
      .delete(`/tasks/${taskToRemove.id}`)
      .then(() => this.setState(state => {
        const tasks = state.tasks.filter(function (task) {
          return task !== taskToRemove
        })

        return {
          tasks
        };
      }))
  }


  toggle(taskToToggle) {
    Axios
      .post(`/tasks/${taskToToggle.id}/toggle`)
      .then(() => this.setState(state => {
        const tasks = state.tasks.map(function (task) {
          return task !== taskToToggle ? task : { ...task, completed: !task.completed }
        })

        return {
          tasks
        };
      }))
  }


  markAllActive(event) {
    event.preventDefault();

    Axios
    .get(`/tasks/toggle/active`)
    .then(() => this.setState(state => {
      const tasks = state.tasks.map(function (task) {
        return { ...task, completed: false }
      })

      return {
        tasks
      };
    }))
  }


  markAllCompleted(event) {
    event.preventDefault();
    Axios
    .get(`/tasks/toggle/active`)
    .then(() => this.setState(state => {
      const tasks = state.tasks.map(function (task) {
        return { ...task, completed: true }
      })

      return {
        tasks
      };
    }))
  }


  updateNewTask(newTask) {
    this.setState({ newTask })
  }


  edit(task) {
    this.setState({ editing: task.id });
  }


  cancel() {
    this.setState({ editing: null });
  }


  render() {
    const tasks = this.state.tasks

    const mapTasks = (task) => {
      return (
        <Task
          key={task.id}
          task={task}
          editing={this.state.editing === task.id}
          onEdit={this.edit.bind(this, task)}
          onSave={this.update.bind(this, task)}
          onToggle={this.toggle.bind(this, task)}
          onCancel={this.cancel.bind(this)}
          onDestroy={this.destroy.bind(this, task)}
        />
      )
    }

    const activeTasks = tasks
      .filter(task => task = !task.completed)
      .map(task => mapTasks(task))

    const completedTasks = tasks
      .filter(task => task = task.completed)
      .map(task => mapTasks(task))

    return (
      <div>
        <TaskInput
          value={this.state.newTask}
          onEnter={this.add.bind(this)}
          onUpdate={this.updateNewTask.bind(this)} />

        {activeTasks.length > 0 && (
          <div className="card mt-4">
            <div className="card-header">
              <div className="d-flex align-items-center justify-content-between">
                <strong>Active</strong>

                <a href="" onClick={this.markAllCompleted.bind(this)}>Mark All Completed</a>
              </div>
            </div>
            <ul className="list-group list-group-flush">
              {activeTasks}
            </ul>
          </div>
        )}

        {completedTasks.length > 0 && (
          <div className="card mt-4">
            <div className="card-header">
              <div className="d-flex align-items-center justify-content-between">
                <strong>Completed</strong>

                <a href="" onClick={this.markAllActive.bind(this)}>Mark All Active</a>
              </div>
            </div>
            <ul className="list-group list-group-flush">
              {completedTasks}
            </ul>
          </div>
        )}
      </div>
    )
  }
}

if (document.getElementById('todo-app')) {
  ReactDOM.render(<TodoApp />, document.getElementById('todo-app'))
}
