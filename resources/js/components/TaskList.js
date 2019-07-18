import React, { Component } from 'react'
import Task from './Task'

export default class TaskList extends Component {
  render() {
    const tasks = this.props.tasks

    return (
      <div className="card mt-4">
        <ul className="list-group list-group-flush">
          {tasks.length > 0 && tasks.map(task =>
            <Task
              key={task.id}
              data={task} />
          )}
        </ul>
      </div>
    )
  }
}
